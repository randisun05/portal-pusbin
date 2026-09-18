<?php

namespace Tests\Feature;

use App\Models\Kegiatan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BatasPresensiTest extends TestCase
{
    use RefreshDatabase;

    protected function makeKegiatan(array $overrides = []): Kegiatan
    {
        return Kegiatan::create(array_merge([
            'nama' => 'Sosialisasi Jabatan Fungsional',
            'slug' => 'sosialisasi-jabatan-fungsional',
            'waktu' => now()->toDateTimeString(),
            'link' => 'https://zoom.us/j/123456',
            'jenis' => 'Sosialisasi',
            'image' => 'post-image/dummy.png',
            'status' => '1',
        ], $overrides));
    }

    public function test_kegiatan_without_deadline_is_never_closed()
    {
        $kegiatan = $this->makeKegiatan(['batas_presensi' => null]);

        $this->assertFalse($kegiatan->isPresensiTertutup());
    }

    public function test_kegiatan_with_future_deadline_is_open()
    {
        $kegiatan = $this->makeKegiatan(['batas_presensi' => now()->addDay()->toDateTimeString()]);

        $this->assertFalse($kegiatan->isPresensiTertutup());
    }

    public function test_kegiatan_with_past_deadline_is_closed()
    {
        $kegiatan = $this->makeKegiatan(['batas_presensi' => now()->subDay()->toDateTimeString()]);

        $this->assertTrue($kegiatan->isPresensiTertutup());
    }

    public function test_presensi_form_shows_closed_message_after_deadline()
    {
        $kegiatan = $this->makeKegiatan(['batas_presensi' => now()->subHour()->toDateTimeString()]);

        $response = $this->get("/absensi/{$kegiatan->slug}");

        $response->assertOk();
        $response->assertSee('sudah berakhir');
        $response->assertDontSee('id="form-konsultasi"', false);
    }

    public function test_presensi_form_is_visible_before_deadline()
    {
        $kegiatan = $this->makeKegiatan(['batas_presensi' => now()->addHour()->toDateTimeString()]);

        $response = $this->get("/absensi/{$kegiatan->slug}");

        $response->assertOk();
        $response->assertSee('id="form-konsultasi"', false);
    }

    public function test_submission_after_deadline_is_rejected()
    {
        $kegiatan = $this->makeKegiatan(['batas_presensi' => now()->subHour()->toDateTimeString()]);

        $response = $this->post("/absensi/{$kegiatan->slug}/store", [
            'nip' => '199001012020011001',
            'nama' => 'Peserta Uji',
            'kegiatan_id' => $kegiatan->id,
            'email' => 'peserta@example.com',
            'jabatan' => 'Analis SDM Aparatur',
            'instansi' => 'BKN',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertStringContainsString('sudah berakhir', session('error'));
        $this->assertDatabaseMissing('absensis', ['nip' => '199001012020011001']);
    }

    public function test_submission_before_deadline_is_accepted()
    {
        $kegiatan = $this->makeKegiatan(['batas_presensi' => now()->addHour()->toDateTimeString()]);

        $response = $this->post("/absensi/{$kegiatan->slug}/store", [
            'nip' => '199001012020011001',
            'nama' => 'Peserta Uji',
            'kegiatan_id' => $kegiatan->id,
            'email' => 'peserta@example.com',
            'jabatan' => 'Analis SDM Aparatur',
            'instansi' => 'BKN',
        ]);

        $response->assertRedirect(route('public.absensi.index'));
        $this->assertDatabaseHas('absensis', ['nip' => '199001012020011001']);
    }

    public function test_select_page_shows_closed_badge_for_past_deadline()
    {
        $kegiatan = $this->makeKegiatan(['batas_presensi' => now()->subHour()->toDateTimeString()]);

        $response = $this->get('/absensi');

        $response->assertOk();
        $response->assertSee('Presensi Ditutup');
    }
}
