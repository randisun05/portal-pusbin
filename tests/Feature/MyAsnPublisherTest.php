<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\Kegiatan;
use App\Models\Sertifikat;
use App\Models\SertifikatTemplate;
use App\Services\JfManagementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * Publikasi sertifikat ke MyASN (alur save lalu upload) dengan seluruh HTTP disimulasikan:
 * tidak ada panggilan nyata ke BKN pada tes otomatis.
 */
class MyAsnPublisherTest extends TestCase
{
    use RefreshDatabase;

    private function sertifikat(): Sertifikat
    {
        config([
            'services.myasn.url' => 'https://gateway.test/pusbin/1',
            'services.bkn.client_id' => 'cid', 'services.bkn.client_secret' => 'sec',
            'services.bkn.siasn_token' => 'token-sso',
            'services.bkn.base_url' => 'https://gateway.test/pusbin/1',
        ]);
        Cache::flush();

        $kegiatan = Kegiatan::create([
            'nama' => 'Kegiatan Uji', 'slug' => 'kegiatan-uji-myasn', 'waktu' => now()->toDateTimeString(),
            'link' => 'https://zoom.us/j/1', 'jenis' => 'Sosialisasi', 'image' => '', 'status' => '1',
        ]);
        $absensi = Absensi::create([
            'nip' => '199001012020011001', 'nama' => 'Peserta Uji', 'kegiatan_id' => $kegiatan->id,
            'email' => 'p@example.test', 'jabatan' => 'Analis', 'instansi' => 'BKN',
        ]);
        $template = SertifikatTemplate::create(['nama' => 'T', 'teks_keterangan' => 'x']);

        return Sertifikat::create(['absensi_id' => $absensi->id, 'template_id' => $template->id, 'nomor_sertifikat' => 'NO/1/2026']);
    }

    private function fakeBkn($upload, $orang = null): void
    {
        Http::fake([
            'apimws.bkn.go.id/oauth2/token' => Http::response(['access_token' => 'prod', 'expires_in' => 3600]),
            'gateway.test/pusbin/1/pns/data-utama/*' => $orang ?? Http::response(['data' => ['id' => 'ORANG-1']]),
            'gateway.test/pusbin/1/sertifikasi/save' => Http::response(['success' => true, 'mapData' => ['rwSertifikasiId' => 'RW-9']]),
            'gateway.test/pusbin/1/upload-dok-rw' => $upload,
        ]);
    }

    public function test_save_lalu_upload_menandai_terkirim(): void
    {
        $s = $this->sertifikat();
        $this->fakeBkn(Http::response(['success' => true, 'data' => ['dok_uri' => 'x']]));

        $hasil = app(JfManagementService::class)->send($s);

        $this->assertSame('terkirim', $hasil->status);
        $this->assertSame('RW-9', $hasil->myasn_riwayat_id);
        $this->assertSame('ORANG-1', $hasil->myasn_orang_id);
        Http::assertSent(fn ($r) => str_ends_with($r->url(), '/sertifikasi/save')
            && $r['pnsOrangId'] === 'ORANG-1' && $r['nomorSertifikat'] === 'NO/1/2026'
            && $r['tanggalSertifikat'] === now()->format('d-m-Y')
            && $r->hasHeader('Auth', 'bearer token-sso'));
        Http::assertSent(fn ($r) => str_ends_with($r->url(), '/upload-dok-rw'));
    }

    public function test_upload_gagal_lalu_kirim_ulang_tidak_membuat_riwayat_ganda(): void
    {
        $s = $this->sertifikat();
        $this->fakeBkn(Http::sequence()->push('error', 500)->push(['success' => true]));

        $gagal = app(JfManagementService::class)->send($s);
        $this->assertSame('gagal_kirim', $gagal->status);
        $this->assertSame('RW-9', $gagal->myasn_riwayat_id);

        $ulang = app(JfManagementService::class)->send($gagal->fresh());

        $this->assertSame('terkirim', $ulang->status);
        $hitung = fn (string $akhir) => Http::recorded(fn ($req) => str_ends_with($req->url(), $akhir))->count();
        $this->assertSame(1, $hitung('/sertifikasi/save'), 'riwayat tidak boleh dibuat dua kali');
        $this->assertSame(2, $hitung('/upload-dok-rw'));
    }

    public function test_nip_tidak_ditemukan_tidak_memanggil_save(): void
    {
        $s = $this->sertifikat();
        $this->fakeBkn(Http::response([]), Http::response(['data' => null], 404));

        $hasil = app(JfManagementService::class)->send($s);

        $this->assertSame('gagal_kirim', $hasil->status);
        $this->assertStringContainsString('tidak ditemukan', $hasil->sent_response);
        Http::assertNotSent(fn ($r) => str_ends_with($r->url(), '/sertifikasi/save'));
    }
}
