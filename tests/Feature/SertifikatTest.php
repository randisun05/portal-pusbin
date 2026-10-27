<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\Kegiatan;
use App\Models\Sertifikat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SertifikatTest extends TestCase
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

    public function test_admin_can_issue_certificate()
    {
        $admin = User::factory()->create();
        $absensi = $this->makeAbsensi();

        $response = $this->actingAs($admin)->post("/admin/sertifikat/{$absensi->id}/issue");

        $response->assertRedirect();
        $this->assertDatabaseHas('sertifikats', ['absensi_id' => $absensi->id]);
    }

    public function test_certificate_cannot_be_issued_twice_for_same_absensi()
    {
        $admin = User::factory()->create();
        $absensi = $this->makeAbsensi();
        $this->actingAs($admin)->post("/admin/sertifikat/{$absensi->id}/issue");

        $this->actingAs($admin)->post("/admin/sertifikat/{$absensi->id}/issue");

        $this->assertSame(1, Sertifikat::where('absensi_id', $absensi->id)->count());
    }

    public function test_certificate_can_be_downloaded_as_pdf()
    {
        $admin = User::factory()->create();
        $absensi = $this->makeAbsensi();
        $this->actingAs($admin)->post("/admin/sertifikat/{$absensi->id}/issue");
        $sertifikat = Sertifikat::where('absensi_id', $absensi->id)->first();

        $response = $this->actingAs($admin)->get("/admin/sertifikat/{$sertifikat->id}/download");

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }
}
