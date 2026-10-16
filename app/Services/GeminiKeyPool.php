<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Klien Gemini dengan rotasi beberapa API key (maksimal 5).
 *
 * Jika key yang sedang dipakai kuotanya habis (429), ditolak (401/403, atau 400
 * "API key not valid") atau server Gemini error (5xx / koneksi gagal), request
 * yang sama diulang dengan key berikutnya secara bergantian. Key terakhir yang
 * berhasil diingat di cache supaya request berikutnya tidak mengulang key yang
 * sudah habis. Error karena isi request-nya sendiri (mis. 400 payload salah)
 * tidak memicu rotasi, karena key lain akan menghasilkan error yang sama.
 */
class GeminiKeyPool
{
    public const MAX_KEYS = 5;

    private const CACHE_KEY = 'gemini_active_key_index';

    /** Batas total waktu satu panggilan (semua percobaan), detik */
    private const TOTAL_BUDGET = 25;

    /** Batas waktu per percobaan, detik */
    private const ATTEMPT_TIMEOUT = 15;

    /** @var string[] */
    private array $keys;

    public function __construct()
    {
        $keys = array_filter(
            (array) config('services.gemini.keys', []),
            fn ($key) => is_string($key) && trim($key) !== ''
        );

        // Kompatibel dengan konfigurasi lama yang hanya memakai satu GEMINI_API_KEY
        if (empty($keys) && filled(config('services.gemini.api_key'))) {
            $keys = [config('services.gemini.api_key')];
        }

        $this->keys = array_slice(array_values(array_unique(array_map('trim', $keys))), 0, self::MAX_KEYS);
    }

    public function count(): int
    {
        return count($this->keys);
    }

    public function isConfigured(): bool
    {
        return $this->count() > 0;
    }

    /**
     * Panggil generateContent dengan payload mentah. Mengembalikan body JSON,
     * atau melempar RuntimeException jika semua key gagal / tidak ada key.
     */
    public function generateContent(array $payload, ?string $model = null): array
    {
        $total = $this->count();

        if ($total === 0) {
            throw new \RuntimeException('Tidak ada API key Gemini yang dikonfigurasi.');
        }

        $model = $model ?: config('services.gemini.model', 'gemini-2.0-flash');
        $start = (int) Cache::get(self::CACHE_KEY, 0) % $total;
        $deadline = microtime(true) + self::TOTAL_BUDGET;
        $lastError = null;

        for ($attempt = 0; $attempt < $total; $attempt++) {
            $remaining = $deadline - microtime(true);
            if ($attempt > 0 && $remaining < 2) {
                break; // waktu habis, jangan membuat pengunjung menunggu lebih lama
            }

            $index = ($start + $attempt) % $total;

            try {
                $response = Http::timeout((int) max(2, min(self::ATTEMPT_TIMEOUT, $remaining)))
                    // Key lewat header, bukan ?key=, supaya tidak tercatat di URL/log/exception
                    ->withHeaders(['x-goog-api-key' => $this->keys[$index]])
                    ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent", $payload);
            } catch (ConnectionException $e) {
                $lastError = 'koneksi gagal';
                $this->logFailure($index, 'koneksi', $lastError);

                continue;
            }

            if ($response->successful()) {
                if ($index !== $start) {
                    Cache::forever(self::CACHE_KEY, $index);
                }

                return $response->json() ?? [];
            }

            $lastError = $response->json('error.message') ?: "HTTP {$response->status()}";
            $this->logFailure($index, $response->status(), $lastError);

            if (! $this->shouldRotate($response)) {
                throw new \RuntimeException("Gemini API menolak request: {$lastError}");
            }
        }

        // Semua key gagal: request berikutnya mulai dari key sesudah yang tadi dicoba pertama
        Cache::forever(self::CACHE_KEY, ($start + 1) % $total);

        throw new \RuntimeException("Semua API key Gemini gagal: {$lastError}");
    }

    private function shouldRotate(Response $response): bool
    {
        $status = $response->status();

        if (in_array($status, [401, 403, 429], true) || $status >= 500) {
            return true;
        }

        // Gemini memakai 400 untuk key tidak valid, tapi juga untuk payload yang salah
        return $status === 400 && (
            str_contains(strtolower((string) $response->json('error.message')), 'api key')
            || collect($response->json('error.details', []))->contains(fn ($d) => ($d['reason'] ?? null) === 'API_KEY_INVALID')
        );
    }

    private function logFailure(int $index, int|string $status, ?string $message): void
    {
        // Hanya nomor urut key yang dicatat, tidak pernah isi key-nya
        Log::warning('GeminiKeyPool: key #'.($index + 1)." gagal ({$status}), mencoba key berikutnya.", ['message' => $message]);
    }
}
