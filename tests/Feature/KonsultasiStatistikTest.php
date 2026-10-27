<?php

namespace Tests\Feature;

use App\Models\KodeKonsultasi;
use App\Models\Konsultasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KonsultasiStatistikTest extends TestCase
{
    use RefreshDatabase;

    protected function makeTiket(array $overrides = []): Konsultasi
    {
        $kode = KodeKonsultasi::create(['jenis' => 'Jabatan Fungsional Kepegawaian', 'kode' => '001']);

        return Konsultasi::create(array_merge([
            'nip' => '199001012020121001',
            'nama' => 'Peserta Konsultasi',
            'email' => 'peserta@example.com',
            'instansi' => 'BKN Pusat',
            'kode_id' => $kode->id,
            'jadwal' => now(),
            'tiket' => 'TKT0001',
            'jawab' => 0,
        ], $overrides));
    }

    public function test_guest_is_redirected_to_login()
    {
        $response = $this->get('/admin/konsultasi-statistik');

        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_konsultasi_statistik()
    {
        $admin = User::factory()->create();
        $this->makeTiket(['jawab' => 1]);
        $this->makeTiket(['instansi' => 'Kementerian Keuangan', 'tiket' => 'TKT0002']);

        $response = $this->actingAs($admin)->get('/admin/konsultasi-statistik');

        $response->assertOk();
        $response->assertSee('Statistik Konsultasi');
        $response->assertSee('BKN Pusat');
        $response->assertSee('Kementerian Keuangan');
        $response->assertSee('Jabatan Fungsional Kepegawaian');
    }

    public function test_statistik_counts_answered_and_unanswered_correctly()
    {
        $admin = User::factory()->create();
        $this->makeTiket(['jawab' => 1, 'tiket' => 'TKT0001']);
        $this->makeTiket(['jawab' => 1, 'tiket' => 'TKT0002']);
        $this->makeTiket(['jawab' => 0, 'tiket' => 'TKT0003']);

        $response = $this->actingAs($admin)->get('/admin/konsultasi-statistik');

        $response->assertOk();
        $response->assertSee('series: [2, 1]', false);
    }
}
