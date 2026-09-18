<?php

namespace Tests\Feature;

use App\Models\Kegiatan;
use App\Models\PesanKontak;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RecaptchaTest extends TestCase
{
    use RefreshDatabase;

    public function test_kontak_form_still_works_when_recaptcha_not_configured()
    {
        config(['services.recaptcha.secret_key' => null]);

        $response = $this->post('/about/kontak-kami', [
            'nama' => 'Warga',
            'email' => 'warga@example.com',
            'pesan' => 'Halo, ada pertanyaan.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('pesan_kontaks', ['email' => 'warga@example.com']);
    }

    public function test_kontak_form_blends_in_success_when_recaptcha_token_missing_but_configured()
    {
        config(['services.recaptcha.secret_key' => 'fake-secret']);

        $response = $this->post('/about/kontak-kami', [
            'nama' => 'Bot',
            'email' => 'bot@example.com',
            'pesan' => 'Pesan dari bot tanpa menyelesaikan captcha.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('pesan_kontaks', ['email' => 'bot@example.com']);
    }

    public function test_kontak_form_succeeds_when_recaptcha_verification_passes()
    {
        config(['services.recaptcha.secret_key' => 'fake-secret']);

        Http::fake([
            'www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true], 200),
        ]);

        $response = $this->post('/about/kontak-kami', [
            'nama' => 'Warga Asli',
            'email' => 'asli@example.com',
            'pesan' => 'Pesan asli setelah selesaikan captcha.',
            'g-recaptcha-response' => 'valid-token-dari-widget',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('pesan_kontaks', ['email' => 'asli@example.com']);

        Http::assertSent(function ($request) {
            return str_contains($request->url(), 'recaptcha/api/siteverify')
                && $request['secret'] === 'fake-secret'
                && $request['response'] === 'valid-token-dari-widget';
        });
    }

    public function test_kontak_form_blends_in_success_when_google_rejects_token()
    {
        config(['services.recaptcha.secret_key' => 'fake-secret']);

        Http::fake([
            'www.google.com/recaptcha/api/siteverify' => Http::response(['success' => false, 'error-codes' => ['invalid-input-response']], 200),
        ]);

        $response = $this->post('/about/kontak-kami', [
            'nama' => 'Bot Pintar',
            'email' => 'botpintar@example.com',
            'pesan' => 'Token palsu.',
            'g-recaptcha-response' => 'token-tidak-valid',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseMissing('pesan_kontaks', ['email' => 'botpintar@example.com']);
    }

    public function test_recaptcha_verification_failure_does_not_block_real_users_when_google_unreachable()
    {
        config(['services.recaptcha.secret_key' => 'fake-secret']);

        Http::fake(function () {
            throw new \Illuminate\Http\Client\ConnectionException('Connection timed out');
        });

        $response = $this->post('/about/kontak-kami', [
            'nama' => 'Warga Saat Google Down',
            'email' => 'saatdown@example.com',
            'pesan' => 'Pesan saat layanan Google gangguan.',
            'g-recaptcha-response' => 'token-apa-saja',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('pesan_kontaks', ['email' => 'saatdown@example.com']);
    }

    public function test_widget_is_not_rendered_when_site_key_not_configured()
    {
        config(['services.recaptcha.site_key' => null]);

        $response = $this->get('/about/kontak-kami');

        $response->assertOk();
        $response->assertDontSee('g-recaptcha');
    }

    public function test_widget_is_rendered_when_site_key_configured()
    {
        config(['services.recaptcha.site_key' => 'fake-site-key']);

        $response = $this->get('/about/kontak-kami');

        $response->assertOk();
        $response->assertSee('g-recaptcha');
        $response->assertSee('fake-site-key');
    }

    public function test_absensi_submission_honors_recaptcha_when_configured()
    {
        config(['services.recaptcha.secret_key' => 'fake-secret']);

        $kegiatan = Kegiatan::create([
            'nama' => 'Kegiatan Captcha Test',
            'slug' => 'kegiatan-captcha-test',
            'waktu' => now()->toDateTimeString(),
            'link' => 'https://zoom.us/j/1',
            'jenis' => 'Sosialisasi',
            'image' => '',
            'status' => '1',
        ]);

        $response = $this->post("/absensi/{$kegiatan->slug}/store", [
            'nip' => '199001012020011001',
            'nama' => 'Peserta',
            'kegiatan_id' => $kegiatan->id,
            'email' => 'peserta@example.com',
            'jabatan' => 'Analis',
            'instansi' => 'BKN',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseMissing('absensis', ['nip' => '199001012020011001']);
    }
}
