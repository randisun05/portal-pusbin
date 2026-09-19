<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SiasnSsoService
{
    /**
     * Verifikasi NIP + password ke SSO SIASN (BKN), memakai grant_type
     * "password" ke endpoint token Keycloak milik BKN - persis alur yang
     * dipakai integrasi SIASN nyata (bukan dikira-kira), lihat komentar di
     * config/services.php. Mengembalikan klaim identitas dari token jika
     * berhasil, atau null jika gagal / belum dikonfigurasi.
     *
     * @return array{nip: ?string, name: ?string, raw: array}|null
     */
    public function authenticate(string $nip, string $password): ?array
    {
        $config = $this->activeConfig();

        if (empty($config['client_id'])) {
            return null;
        }

        try {
            $response = Http::asForm()->timeout(15)->post($config['url'], [
                'grant_type' => 'password',
                'client_id' => $config['client_id'],
                'username' => $nip,
                'password' => $password,
            ]);

            if (! $response->successful()) {
                Log::info('SiasnSsoService: SSO SIASN menolak kredensial.', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);

                return null;
            }

            $accessToken = $response->json('access_token');

            if (empty($accessToken)) {
                return null;
            }

            $claims = $this->decodeJwtClaims($accessToken);

            return [
                'nip' => $claims['preferred_username'] ?? $nip,
                'name' => $claims['name'] ?? null,
                'raw' => $claims,
            ];
        } catch (\Throwable $e) {
            Log::warning('SiasnSsoService: gagal menghubungi SSO SIASN.', ['error' => $e->getMessage()]);

            return null;
        }
    }

    public function isConfigured(): bool
    {
        return ! empty($this->activeConfig()['client_id']);
    }

    /**
     * @return array{url: string, client_id: ?string}
     */
    protected function activeConfig(): array
    {
        $mode = config('services.siasn.mode', 'training') === 'production' ? 'production' : 'training';

        return config("services.siasn.sso.{$mode}");
    }

    /**
     * Decode payload JWT tanpa verifikasi signature. Aman dilakukan di sini
     * karena token ini diperoleh langsung dari server BKN lewat panggilan
     * server-to-server HTTPS (bukan token yang dikirim klien), sekadar untuk
     * membaca klaim identitas (preferred_username, name, dst), bukan untuk
     * memutuskan otorisasi tanpa pengecekan lain.
     */
    protected function decodeJwtClaims(string $jwt): array
    {
        $segments = explode('.', $jwt);

        if (count($segments) !== 3) {
            return [];
        }

        $base64 = strtr($segments[1], '-_', '+/');
        $base64 .= str_repeat('=', (4 - strlen($base64) % 4) % 4);

        $payload = base64_decode($base64, true);
        $claims = $payload ? json_decode($payload, true) : null;

        return is_array($claims) ? $claims : [];
    }
}
