<?php

namespace Tests\Feature;

use App\Models\Faq;
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
}
