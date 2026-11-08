<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\Kegiatan;
use App\Models\Sertifikat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SertifikatUnduhTest extends TestCase
{
    use RefreshDatabase;

    protected function makeKegiatan(): Kegiatan
    {
        return Kegiatan::create([
            'nama' => 'Ujikom Periode I',
            'slug' => 'ujikom-periode-i',
            'waktu' => now()->toDateTimeString(),
            'link' => 'https://example.com',
            'jenis' => 'Ujikom',
            'image' => 'post-image/dummy.png',
            'status' => '1',
        ]);
    }

    protected function makeAbsensi(Kegiatan $kegiatan, string $nip): Absensi
    {
        return Absensi::create([
            'kegiatan_id' => $kegiatan->id,
            'nip' => $nip,
            'nama' => 'Peserta Ujikom',
            'email' => 'peserta@example.com',
            'jabatan' => 'Analis',
            'instansi' => 'BKN',
        ]);
    }

    public function test_form_page_lists_available_kegiatan()
    {
        $kegiatan = $this->makeKegiatan();

        $response = $this->get('/sertifikat/unduh');

        $response->assertOk();
        $response->assertSee($kegiatan->nama);
    }

    public function test_participant_can_download_own_certificate_without_login()
    {
        $kegiatan = $this->makeKegiatan();
        $absensi = $this->makeAbsensi($kegiatan, '199001012020011001');
        Sertifikat::create([
            'absensi_id' => $absensi->id,
            'nomor_sertifikat' => Sertifikat::generateNomor(),
        ]);

        $response = $this->post('/sertifikat/unduh', [
            'nip' => '199001012020011001',
            'kegiatan_id' => $kegiatan->id,
        ]);

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_wrong_nip_shows_not_found_error()
    {
        $kegiatan = $this->makeKegiatan();
        $this->makeAbsensi($kegiatan, '199001012020011001');

        $response = $this->post('/sertifikat/unduh', [
            'nip' => '000000000000000000',
            'kegiatan_id' => $kegiatan->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertStringContainsString('tidak ditemukan', session('error'));
    }

    public function test_not_yet_issued_certificate_shows_pending_error()
    {
        $kegiatan = $this->makeKegiatan();
        $this->makeAbsensi($kegiatan, '199001012020011001');

        $response = $this->post('/sertifikat/unduh', [
            'nip' => '199001012020011001',
            'kegiatan_id' => $kegiatan->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertStringContainsString('belum diterbitkan', session('error'));
    }

    public function test_honeypot_blocks_bot_submission_silently()
    {
        $kegiatan = $this->makeKegiatan();
        $absensi = $this->makeAbsensi($kegiatan, '199001012020011001');
        Sertifikat::create([
            'absensi_id' => $absensi->id,
            'nomor_sertifikat' => Sertifikat::generateNomor(),
        ]);

        $response = $this->post('/sertifikat/unduh', [
            'nip' => '199001012020011001',
            'kegiatan_id' => $kegiatan->id,
            'website' => 'http://spambot.example.com',
        ]);

        $response->assertRedirect();
        $this->assertStringContainsString('tidak ditemukan', session('error'));
    }

    public function test_download_endpoint_is_rate_limited()
    {
        $kegiatan = $this->makeKegiatan();

        for ($i = 0; $i < 10; $i++) {
            $this->post('/sertifikat/unduh', ['nip' => 'x', 'kegiatan_id' => $kegiatan->id]);
        }

        $response = $this->post('/sertifikat/unduh', ['nip' => 'x', 'kegiatan_id' => $kegiatan->id]);

        $response->assertStatus(429);
    }

    public function test_downloaded_certificate_matches_correct_participant_data()
    {
        $kegiatan = $this->makeKegiatan();
        $absensiA = $this->makeAbsensi($kegiatan, '111111111111111111');
        $absensiB = $this->makeAbsensi($kegiatan, '222222222222222222');
        Sertifikat::create(['absensi_id' => $absensiA->id, 'nomor_sertifikat' => Sertifikat::generateNomor()]);
        $sertifikatB = Sertifikat::create(['absensi_id' => $absensiB->id, 'nomor_sertifikat' => Sertifikat::generateNomor()]);

        $response = $this->post('/sertifikat/unduh', [
            'nip' => '222222222222222222',
            'kegiatan_id' => $kegiatan->id,
        ]);

        $response->assertOk();
        $expectedFilename = str_replace('/', '-', $sertifikatB->nomor_sertifikat);
        $this->assertStringContainsString($expectedFilename, $response->headers->get('content-disposition'));
    }
}
