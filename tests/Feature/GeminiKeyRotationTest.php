<?php

namespace Tests\Feature;

use App\Models\PengaturanChat;
use App\Models\User;
use App\Services\GeminiChatService;
use App\Services\GeminiKeyPool;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GeminiKeyRotationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        config([
            'services.gemini.api_key' => null,
            'services.gemini.keys' => ['k1', 'k2', 'k3', '', null],
        ]);
    }

    private function sukses(string $teks = 'Halo dari Gemini'): array
    {
        return ['candidates' => [['content' => ['parts' => [['text' => $teks]]]]]];
    }

    private function key($request): string
    {
        return $request->header('x-goog-api-key')[0] ?? '';
    }

    /** Respons ditentukan per key: ['k1' => 429, 'k2' => 200, ...] */
    private function fakePerKey(array $peta): void
    {
        $this->httpBaru();
        Http::fake(function ($request) use ($peta) {
            $status = $peta[$this->key($request)] ?? 500;

            return $status === 200
                ? Http::response($this->sukses())
                : Http::response(['error' => ['message' => "gagal {$status}"]], $status);
        });
    }

    /** Http::fake() berikutnya tidak menimpa stub lama, jadi mulai dari client yang bersih */
    private function httpBaru(): void
    {
        Http::swap(new \Illuminate\Http\Client\Factory());
    }

    private function urutanKey(): array
    {
        return collect(Http::recorded())->map(fn ($pair) => $this->key($pair[0]))->all();
    }

    public function test_key_kosong_dilewati_dan_dibatasi_lima(): void
    {
        config(['services.gemini.keys' => ['a', '', 'b', 'a', 'c', 'd', 'e', 'f', 'g']]);

        $pool = new GeminiKeyPool();

        $this->assertSame(5, $pool->count());
        $this->assertTrue($pool->isConfigured());
    }

    public function test_tanpa_key_tidak_terkonfigurasi(): void
    {
        config(['services.gemini.keys' => [null, ''], 'services.gemini.api_key' => null]);

        $this->assertFalse((new GeminiKeyPool())->isConfigured());
        $this->expectException(\RuntimeException::class);
        (new GeminiKeyPool())->generateContent([]);
    }

    public function test_konfigurasi_lama_satu_key_tetap_berfungsi(): void
    {
        config(['services.gemini.keys' => [], 'services.gemini.api_key' => 'kunci-lama']);
        $this->fakePerKey(['kunci-lama' => 200]);

        $pool = new GeminiKeyPool();

        $this->assertSame(1, $pool->count());
        $this->assertSame('Halo dari Gemini', data_get($pool->generateContent([]), 'candidates.0.content.parts.0.text'));
    }

    public function test_pindah_ke_key_berikutnya_saat_kuota_habis_dan_diingat(): void
    {
        $this->fakePerKey(['k1' => 429, 'k2' => 429, 'k3' => 200]);

        (new GeminiKeyPool())->generateContent([]);
        $this->assertSame(['k1', 'k2', 'k3'], $this->urutanKey());

        // Request berikutnya langsung memakai key yang terakhir berhasil
        $this->httpBaru();
        Http::fake(fn () => Http::response($this->sukses()));
        (new GeminiKeyPool())->generateContent([]);
        $this->assertSame('k3', $this->key(collect(Http::recorded())->last()[0]));
        Http::assertSentCount(1);
    }

    public function test_pindah_key_saat_key_tidak_valid_atau_server_error(): void
    {
        Http::fake(function ($request) {
            return match ($this->key($request)) {
                'k1' => Http::response(['error' => ['message' => 'API key not valid. Please pass a valid API key.']], 400),
                'k2' => Http::response(['error' => ['message' => 'overloaded']], 503),
                default => Http::response($this->sukses()),
            };
        });

        (new GeminiKeyPool())->generateContent([]);

        $this->assertSame(['k1', 'k2', 'k3'], $this->urutanKey());
    }

    public function test_error_payload_400_tidak_memutar_semua_key(): void
    {
        Http::fake(['*' => Http::response(['error' => ['message' => 'Invalid JSON payload received.']], 400)]);

        try {
            (new GeminiKeyPool())->generateContent([]);
            $this->fail('Harus melempar exception');
        } catch (\RuntimeException $e) {
            $this->assertStringContainsString('Invalid JSON payload', $e->getMessage());
        }

        Http::assertSentCount(1);
    }

    public function test_semua_key_gagal_melempar_exception_dan_mulai_dari_key_berikutnya(): void
    {
        $this->fakePerKey(['k1' => 429, 'k2' => 429, 'k3' => 429]);

        try {
            (new GeminiKeyPool())->generateContent([]);
            $this->fail('Harus melempar exception');
        } catch (\RuntimeException $e) {
            $this->assertStringContainsString('Semua API key Gemini gagal', $e->getMessage());
        }
        Http::assertSentCount(3);

        // Putaran berikutnya dimulai dari k2 supaya beban merata
        $this->fakePerKey(['k1' => 200, 'k2' => 200, 'k3' => 200]);
        (new GeminiKeyPool())->generateContent([]);
        $this->assertSame('k2', $this->key(collect(Http::recorded())->last()[0]));
    }

    public function test_key_dikirim_lewat_header_bukan_url(): void
    {
        Http::fake(['*' => Http::response($this->sukses())]);

        (new GeminiKeyPool())->generateContent([]);

        Http::assertSent(fn ($request) => ! str_contains($request->url(), 'key=') && $this->key($request) === 'k1');
    }

    public function test_chat_service_tetap_mengembalikan_null_jika_semua_key_gagal(): void
    {
        $this->fakePerKey(['k1' => 429, 'k2' => 429, 'k3' => 429]);

        $this->assertNull(app(GeminiChatService::class)->answer('Halo?', collect()));
    }

    public function test_chat_publik_memakai_key_cadangan(): void
    {
        PengaturanChat::current()->update(['provider' => 'gemini']);
        $this->fakePerKey(['k1' => 429, 'k2' => 200]);

        $this->postJson('/chat/ask', ['question' => 'Halo?'])
            ->assertOk()
            ->assertJson(['answer' => 'Halo dari Gemini']);

        $this->assertSame(['k1', 'k2'], $this->urutanKey());
    }

    public function test_halaman_pengaturan_menampilkan_jumlah_key(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->get('/admin/pengaturan-chat')
            ->assertOk()
            ->assertSee('3 API key terkonfigurasi (dipakai bergantian)');

        config(['services.gemini.keys' => [], 'services.gemini.api_key' => null]);
        $this->actingAs($admin)->get('/admin/pengaturan-chat')
            ->assertOk()
            ->assertSee('API key belum diisi (GEMINI_API_KEY_1 s/d _5)');
    }
}
