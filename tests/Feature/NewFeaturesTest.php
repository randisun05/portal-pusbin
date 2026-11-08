<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Jdihjfk;
use App\Models\Kegiatan;
use App\Models\Layanan;
use App\Models\Post;
use App\Models\Sertifikat;
use App\Models\Survei;
use App\Models\SurveiIndikator;
use App\Models\SurveiPublic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewFeaturesTest extends TestCase
{
    use RefreshDatabase;

    protected function makeAbsensi(): Absensi
    {
        $kegiatan = Kegiatan::create([
            'nama' => 'Ujikom Periode I',
            'slug' => 'ujikom-periode-i',
            'waktu' => now()->toDateTimeString(),
            'link' => 'https://example.com',
            'jenis' => 'Ujikom',
            'image' => 'post-image/dummy.png',
            'status' => '1',
        ]);

        return Absensi::create([
            'kegiatan_id' => $kegiatan->id,
            'nip' => '199001012020011001',
            'nama' => 'Peserta Ujikom',
            'email' => 'peserta@example.com',
            'jabatan' => 'Analis',
            'instansi' => 'BKN',
        ]);
    }

    // --- Fitur A: Export Excel & PDF ---

    public function test_admin_can_export_absensi_to_excel()
    {
        $admin = User::factory()->create();
        $this->makeAbsensi();

        $response = $this->actingAs($admin)->get('/admin/absensi/export');

        $response->assertOk();
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function test_admin_can_print_daftar_hadir_pdf()
    {
        $admin = User::factory()->create();
        $this->makeAbsensi();

        $response = $this->actingAs($admin)->get('/admin/absensi/daftar-hadir');

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_guest_cannot_access_absensi_export()
    {
        $response = $this->get('/admin/absensi/export');

        $response->assertRedirect('/login');
    }

    public function test_admin_can_export_survei_responses_to_excel()
    {
        $admin = User::factory()->create();
        $survei = Survei::create(['title' => 'Survei Layanan', 'type' => 2]);
        $indikator = SurveiIndikator::create(['title' => 'Kualitas Layanan']);
        SurveiPublic::create([
            'survei_id' => $survei->id,
            'indikator_id' => $indikator->id,
            'nip' => '199001012020011001',
            'velue' => 'Baik',
        ]);

        $response = $this->actingAs($admin)->get("/admin/survei-statistik/{$survei->id}/export");

        $response->assertOk();
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    // --- Fitur B: Verifikasi sertifikat + QR ---

    public function test_public_can_verify_valid_certificate_number()
    {
        $admin = User::factory()->create();
        $absensi = $this->makeAbsensi();
        $this->actingAs($admin)->post("/admin/sertifikat/{$absensi->id}/issue");
        $sertifikat = Sertifikat::where('absensi_id', $absensi->id)->first();

        $response = $this->get('/verifikasi-sertifikat?nomor=' . urlencode($sertifikat->nomor_sertifikat));

        $response->assertOk();
        $response->assertSee('Sertifikat Valid');
        $response->assertSee('Peserta Ujikom');
    }

    public function test_verification_reports_not_found_for_unknown_number()
    {
        $response = $this->get('/verifikasi-sertifikat?nomor=SERT/2026/99999');

        $response->assertOk();
        $response->assertSee('tidak ditemukan');
    }

    public function test_certificate_pdf_embeds_qr_code()
    {
        $admin = User::factory()->create();
        $absensi = $this->makeAbsensi();
        $this->actingAs($admin)->post("/admin/sertifikat/{$absensi->id}/issue");
        $sertifikat = Sertifikat::where('absensi_id', $absensi->id)->first();

        $response = $this->actingAs($admin)->get("/admin/sertifikat/{$sertifikat->id}/cetak");

        $response->assertOk();
        $response->assertSee('data:image', false);
    }

    public function test_verification_endpoint_is_rate_limited()
    {
        for ($i = 0; $i < 10; $i++) {
            $this->get('/verifikasi-sertifikat?nomor=TEST' . $i);
        }

        $response = $this->get('/verifikasi-sertifikat?nomor=TEST-OVER-LIMIT');

        $response->assertStatus(429);
    }

    // --- Fitur C: Pencarian global ---

    public function test_search_finds_matching_post()
    {
        $category = Category::create(['name' => 'Pengumuman', 'slug' => 'pengumuman']);
        $author = User::factory()->create();

        $post = Post::create([
            'category_id' => $category->id,
            'user_id' => $author->id,
            'title' => 'Pengumuman Ujikom Periode Khusus',
            'slug' => 'pengumuman-ujikom-periode-khusus',
            'excerpt' => 'Ringkasan pengumuman',
            'body' => 'Isi pengumuman',
        ]);

        $response = $this->get('/cari?q=Ujikom');

        $response->assertOk();
        $response->assertSee($post->title);
    }

    public function test_search_finds_matching_faq()
    {
        Faq::create([
            'pertanyaan' => 'Bagaimana cara mendaftar konsultasi?',
            'jawaban' => 'Melalui menu konsultasi online.',
            'kategori' => 'Umum',
            'urutan' => 1,
        ]);

        $response = $this->get('/cari?q=konsultasi');

        $response->assertOk();
        $response->assertSee('Bagaimana cara mendaftar konsultasi?');
    }

    public function test_search_only_shows_published_repository_documents()
    {
        Jdihjfk::create([
            'title' => 'Dokumen Publik Kepegawaian',
            'deskripsi' => 'dokumen',
            'status' => Jdihjfk::STATUS_PUBLISHED,
        ]);
        Jdihjfk::create([
            'title' => 'Dokumen Internal Kepegawaian',
            'deskripsi' => 'dokumen',
            'status' => Jdihjfk::STATUS_INTERNAL,
        ]);

        $response = $this->get('/cari?q=Kepegawaian');

        $response->assertOk();
        $response->assertSee('Dokumen Publik Kepegawaian');
        $response->assertDontSee('Dokumen Internal Kepegawaian');
    }

    public function test_search_only_shows_active_layanan()
    {
        Layanan::create([
            'nama' => 'Layanan Aktif Kompetensi',
            'deskripsi' => 'aktif',
            'link' => 'https://example.com/aktif',
            'status' => '1',
        ]);
        Layanan::create([
            'nama' => 'Layanan Nonaktif Kompetensi',
            'deskripsi' => 'nonaktif',
            'link' => 'https://example.com/nonaktif',
            'status' => '0',
        ]);

        $response = $this->get('/cari?q=Kompetensi');

        $response->assertOk();
        $response->assertSee('Layanan Aktif Kompetensi');
        $response->assertDontSee('Layanan Nonaktif Kompetensi');
    }

    public function test_search_with_empty_query_shows_no_results_section()
    {
        $response = $this->get('/cari');

        $response->assertOk();
        $response->assertDontSee('Ditemukan');
    }
}
