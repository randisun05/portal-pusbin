<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\Kegiatan;
use App\Models\Lampiran;
use App\Models\PesanKontak;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LampiranUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    protected function makeKegiatan(array $overrides = []): Kegiatan
    {
        return Kegiatan::create(array_merge([
            'nama' => 'Sosialisasi Lampiran',
            'slug' => 'sosialisasi-lampiran',
            'waktu' => now()->toDateTimeString(),
            'link' => 'https://zoom.us/j/123456',
            'jenis' => 'Sosialisasi',
            'image' => '',
            'status' => '1',
        ], $overrides));
    }

    public function test_absensi_checkin_can_attach_lampiran()
    {
        $kegiatan = $this->makeKegiatan();
        $file = UploadedFile::fake()->create('bukti.pdf', 200, 'application/pdf');

        $response = $this->post("/absensi/{$kegiatan->slug}/store", [
            'nip' => '199001012020011001',
            'nama' => 'Peserta Uji',
            'kegiatan_id' => $kegiatan->id,
            'email' => 'peserta@example.com',
            'jabatan' => 'Analis SDM Aparatur',
            'instansi' => 'BKN',
            'rating' => 3,
            'lampiran' => $file,
        ]);

        $response->assertRedirect(route('public.absensi.index'));
        $absensi = Absensi::where('nip', '199001012020011001')->firstOrFail();
        $this->assertCount(1, $absensi->lampirans);
        Storage::disk('public')->assertExists($absensi->lampirans->first()->path);
        $this->assertSame('bukti.pdf', $absensi->lampirans->first()->nama_asli);
    }

    public function test_lampiran_is_optional_for_absensi()
    {
        $kegiatan = $this->makeKegiatan();

        $response = $this->post("/absensi/{$kegiatan->slug}/store", [
            'nip' => '199001012020011002',
            'nama' => 'Peserta Uji',
            'kegiatan_id' => $kegiatan->id,
            'email' => 'peserta2@example.com',
            'jabatan' => 'Analis SDM Aparatur',
            'instansi' => 'BKN',
            'rating' => 3,
        ]);

        $response->assertRedirect(route('public.absensi.index'));
        $absensi = Absensi::where('nip', '199001012020011002')->firstOrFail();
        $this->assertCount(0, $absensi->lampirans);
    }

    public function test_absensi_rejects_invalid_lampiran_mime()
    {
        $kegiatan = $this->makeKegiatan();
        $file = UploadedFile::fake()->create('script.exe', 50, 'application/octet-stream');

        $response = $this->post("/absensi/{$kegiatan->slug}/store", [
            'nip' => '199001012020011003',
            'nama' => 'Peserta Uji',
            'kegiatan_id' => $kegiatan->id,
            'email' => 'peserta3@example.com',
            'jabatan' => 'Analis SDM Aparatur',
            'instansi' => 'BKN',
            'rating' => 3,
            'lampiran' => $file,
        ]);

        $response->assertSessionHasErrors('lampiran');
        $this->assertDatabaseMissing('absensis', ['nip' => '199001012020011003']);
    }

    public function test_absensi_rejects_oversized_lampiran()
    {
        $kegiatan = $this->makeKegiatan();
        $file = UploadedFile::fake()->create('besar.pdf', 6000, 'application/pdf');

        $response = $this->post("/absensi/{$kegiatan->slug}/store", [
            'nip' => '199001012020011004',
            'nama' => 'Peserta Uji',
            'kegiatan_id' => $kegiatan->id,
            'email' => 'peserta4@example.com',
            'jabatan' => 'Analis SDM Aparatur',
            'instansi' => 'BKN',
            'rating' => 3,
            'lampiran' => $file,
        ]);

        $response->assertSessionHasErrors('lampiran');
        $this->assertDatabaseMissing('absensis', ['nip' => '199001012020011004']);
    }

    public function test_konsultasi_registration_can_attach_lampiran()
    {
        $kegiatan = $this->makeKegiatan(['jenis' => 'Konsultasi', 'slug' => 'konsultasi-lampiran']);
        $file = UploadedFile::fake()->create('pertanyaan.docx', 150);

        $response = $this->post("/konsultasi/{$kegiatan->slug}/store", [
            'nip' => '199002022020011002',
            'nama' => 'Peserta Konsultasi',
            'kegiatan_id' => $kegiatan->id,
            'email' => 'konsultasi@example.com',
            'jabatan' => 'Analis SDM Aparatur',
            'instansi' => 'BKN',
            'lampiran' => $file,
        ]);

        $response->assertRedirect(route('public.konsultasi.index'));
        $absensi = Absensi::where('nip', '199002022020011002')->firstOrFail();
        $this->assertCount(1, $absensi->lampirans);
    }

    public function test_rsvp_kegiatan_store_route_works_without_rating_and_accepts_lampiran()
    {
        $kegiatan = $this->makeKegiatan(['slug' => 'rsvp-lampiran']);
        $file = UploadedFile::fake()->create('surat-tugas.pdf', 100, 'application/pdf');

        $response = $this->post("/kegiatan/{$kegiatan->slug}/store", [
            'nip' => '199003032020011003',
            'nama' => 'Peserta RSVP',
            'kegiatan_id' => $kegiatan->id,
            'email' => 'rsvp@example.com',
            'jabatan' => 'Analis SDM Aparatur',
            'instansi' => 'BKN',
            'lampiran' => $file,
        ]);

        $response->assertRedirect(route('public.kegiatan.index'));
        $absensi = Absensi::where('nip', '199003032020011003')->firstOrFail();
        $this->assertCount(1, $absensi->lampirans);
    }

    public function test_kontak_form_can_attach_lampiran()
    {
        $file = UploadedFile::fake()->create('bukti-transaksi.jpg', 80, 'image/jpeg');

        $response = $this->post('/about/kontak-kami', [
            'nama' => 'Budi Santoso',
            'email' => 'budi.lampiran@example.com',
            'pesan' => 'Pertanyaan dengan lampiran.',
            'lampiran' => $file,
        ]);

        $response->assertRedirect('/about/kontak-kami');
        $pesan = PesanKontak::where('email', 'budi.lampiran@example.com')->firstOrFail();
        $this->assertCount(1, $pesan->lampirans);
        Storage::disk('public')->assertExists($pesan->lampirans->first()->path);
    }

    public function test_admin_absensi_index_shows_lampiran_download_link()
    {
        $admin = User::factory()->create();
        $kegiatan = $this->makeKegiatan(['slug' => 'absensi-admin-lampiran']);
        $absensi = Absensi::create([
            'nip' => '199004042020011004',
            'nama' => 'Peserta Admin',
            'kegiatan_id' => $kegiatan->id,
            'email' => 'admin-view@example.com',
            'jabatan' => 'Analis',
            'instansi' => 'BKN',
        ]);
        $absensi->simpanLampiran(UploadedFile::fake()->create('lampiran.pdf', 100, 'application/pdf'));

        $response = $this->actingAs($admin)->get('/admin/absensi');

        $response->assertOk();
        $response->assertSee('Unduh');
    }

    public function test_admin_pesankontak_show_displays_lampiran_link()
    {
        $admin = User::factory()->create();
        $pesan = PesanKontak::create([
            'nama' => 'Pengirim',
            'email' => 'pengirim@example.com',
            'pesan' => 'Isi pesan.',
        ]);
        $pesan->simpanLampiran(UploadedFile::fake()->create('lampiran.pdf', 100, 'application/pdf'));

        $response = $this->actingAs($admin)->get("/admin/pesankontak/{$pesan->id}");

        $response->assertOk();
        $response->assertSee($pesan->lampirans->first()->nama_asli);
    }

    public function test_lampiran_relation_is_isolated_per_model()
    {
        $kegiatan = $this->makeKegiatan(['slug' => 'isolasi-lampiran']);
        $absensi = Absensi::create([
            'nip' => '199005052020011005',
            'nama' => 'Peserta Isolasi',
            'kegiatan_id' => $kegiatan->id,
            'email' => 'isolasi@example.com',
            'jabatan' => 'Analis',
            'instansi' => 'BKN',
        ]);
        $pesan = PesanKontak::create([
            'nama' => 'Pengirim Isolasi',
            'email' => 'isolasi-kontak@example.com',
            'pesan' => 'Isi pesan isolasi.',
        ]);

        $absensi->simpanLampiran(UploadedFile::fake()->create('a.pdf', 10, 'application/pdf'));
        $pesan->simpanLampiran(UploadedFile::fake()->create('b.pdf', 10, 'application/pdf'));

        $this->assertCount(1, $absensi->fresh()->lampirans);
        $this->assertCount(1, $pesan->fresh()->lampirans);
        $this->assertSame(2, Lampiran::count());
        $this->assertNotSame(
            $absensi->lampirans->first()->id,
            $pesan->lampirans->first()->id
        );
    }
}
