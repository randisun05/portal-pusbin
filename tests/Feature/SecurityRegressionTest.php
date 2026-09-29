<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Kegiatan;
use App\Models\Post;
use App\Models\SertifikatTemplate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Regression tests untuk temuan audit: memastikan celah keamanan yang
 * sudah diperbaiki (kredensial bocor, route admin yang crash) tidak
 * diam-diam muncul kembali di kemudian hari.
 */
class SecurityRegressionTest extends TestCase
{
    use RefreshDatabase;

    public function test_debug_routes_with_hardcoded_bkn_credentials_are_removed()
    {
        foreach (['/get', '/getapi', '/getauth', '/getpublic'] as $path) {
            $this->get($path)->assertNotFound();
        }
    }

    public function test_admin_konsultasi_create_route_no_longer_crashes()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get('/admin/konsultasi/create');

        $response->assertNotFound();
    }

    public function test_admin_konsultasi_create_redirects_guest_to_login_rather_than_crashing()
    {
        $response = $this->get('/admin/konsultasi/create');

        $response->assertRedirect('/login');
    }

    public function test_chat_ask_is_rate_limited()
    {
        config(['services.anthropic.api_key' => null]);
        Faq::create(['pertanyaan' => 'Tes?', 'jawaban' => 'Jawaban.']);

        for ($i = 1; $i <= 12; $i++) {
            $this->postJson('/chat/ask', ['question' => 'Tes'])->assertOk();
        }

        $this->postJson('/chat/ask', ['question' => 'Tes'])->assertStatus(429);
    }

    public function test_kontak_form_is_rate_limited()
    {
        for ($i = 1; $i <= 5; $i++) {
            $this->post('/about/kontak-kami', [
                'nama' => "Tester $i",
                'email' => "tester{$i}@example.com",
                'pesan' => 'Tes rate limit.',
            ])->assertRedirect('/about/kontak-kami');
        }

        $this->post('/about/kontak-kami', [
            'nama' => 'Tester Kelebihan',
            'email' => 'lebih@example.com',
            'pesan' => 'Tes rate limit.',
        ])->assertStatus(429);
    }

    public function test_login_is_rate_limited()
    {
        $admin = User::factory()->create(['password' => bcrypt('password-benar')]);

        for ($i = 1; $i <= 5; $i++) {
            $this->post('/login', [
                'email' => $admin->email,
                'password' => 'salah',
            ]);
        }

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'salah',
        ]);

        $response->assertStatus(429);
    }

    public function test_certificate_keterangan_escapes_public_submitted_name()
    {
        $template = SertifikatTemplate::create([
            'nama' => 'Template Uji',
            'teks_keterangan' => 'Kepada {nama}, NIP {nip}.',
        ]);

        $kegiatan = Kegiatan::create([
            'nama' => 'Kegiatan Uji',
            'slug' => 'kegiatan-uji-xss',
            'waktu' => now()->toDateTimeString(),
            'link' => 'https://zoom.us/j/123',
            'jenis' => 'Sosialisasi',
            'image' => '',
            'status' => '1',
        ]);

        $absensi = Absensi::create([
            'nip' => '199001012020011001',
            'nama' => '<script>alert(1)</script>',
            'kegiatan_id' => $kegiatan->id,
            'email' => 'peserta@example.com',
            'jabatan' => 'Analis',
            'instansi' => 'BKN',
        ]);

        $keterangan = $template->renderKeterangan($absensi);

        $this->assertStringNotContainsString('<script>', $keterangan);
        $this->assertStringContainsString('&lt;script&gt;', $keterangan);
    }

    public function test_post_body_is_sanitized_against_script_injection()
    {
        $admin = User::factory()->create();
        $category = Category::create(['name' => 'Kategori Uji', 'slug' => 'kategori-uji']);

        $post = Post::create([
            'category_id' => $category->id,
            'user_id' => $admin->id,
            'title' => 'Judul Uji XSS',
            'slug' => 'judul-uji-xss',
            'excerpt' => 'Ringkasan',
            'body' => '<p>Teks aman</p><script>alert(1)</script><img src=x onerror=alert(2)>',
            'publish_at' => now(),
        ]);

        $post->refresh();

        $this->assertStringNotContainsString('<script>', $post->body);
        $this->assertStringNotContainsString('onerror', $post->body);
        $this->assertStringContainsString('Teks aman', $post->body);
    }

    public function test_security_headers_are_present_on_response()
    {
        $response = $this->get('/');

        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }
}
