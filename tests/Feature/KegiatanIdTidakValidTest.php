<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\Kegiatan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * BUG-06: presensi/pendaftaran konsultasi menerima kegiatan_id yang tidak ada
 * sehingga tercipta data absensi yatim dan respons "berhasil".
 */
class KegiatanIdTidakValidTest extends TestCase
{
    use RefreshDatabase;

    private array $data = [
        'nip' => '198501012010011001', 'nama' => 'Uji', 'email' => 'uji@example.test',
        'jabatan' => 'Analis SDM Aparatur', 'instansi' => 'X', 'rating' => 3,
    ];

    public function test_presensi_dengan_kegiatan_tidak_ada_ditolak()
    {
        $this->postJson('/absensi/apa-saja/store', $this->data + ['kegiatan_id' => 9999])
            ->assertStatus(422)->assertJsonValidationErrors('kegiatan_id');

        $this->assertSame(0, Absensi::count());
    }

    public function test_pendaftaran_konsultasi_dengan_kegiatan_tidak_ada_ditolak()
    {
        $this->postJson('/konsultasi/apa-saja/store', $this->data + ['kegiatan_id' => 9999])
            ->assertStatus(422)->assertJsonValidationErrors('kegiatan_id');

        $this->assertSame(0, Absensi::count());
    }
}
