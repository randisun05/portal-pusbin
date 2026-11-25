<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\Kegiatan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * BUG-03: pendaftaran konsultasi tersimpan lalu error 500 bila SMTP mati,
 * sehingga pemohon mengira gagal dan mendaftar ulang ("sudah terdaftar").
 */
class KonsultasiBookingEmailGagalTest extends TestCase
{
    use RefreshDatabase;

    public function test_pendaftaran_tetap_berhasil_walau_email_konfirmasi_gagal_dikirim()
    {
        $kegiatan = Kegiatan::create([
            'nama' => 'Konsultasi Uji', 'slug' => 'konsultasi-uji', 'jenis' => 'Konsultasi',
            'waktu' => now()->addDay()->toDateTimeString(), 'link' => 'https://zoom.us/j/1',
            'image' => 'post-image/dummy.png', 'status' => '1',
        ]);

        Mail::shouldReceive('to')->andThrow(new \RuntimeException('SMTP down'));

        $this->post("/konsultasi/{$kegiatan->slug}/store", [
            'nip' => '198501012010011001', 'nama' => 'Uji', 'kegiatan_id' => $kegiatan->id,
            'email' => 'uji@example.test', 'jabatan' => 'Analis SDM Aparatur', 'instansi' => 'X',
        ])->assertRedirect(route('public.konsultasi.index'));

        $this->assertSame(1, Absensi::count());
    }
}
