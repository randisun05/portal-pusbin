<?php

namespace Tests\Feature;

use App\Models\KodeKonsultasi;
use App\Models\Konsultasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KonsultasiAnswerTest extends TestCase
{
    use RefreshDatabase;

    protected function makeTicket(): Konsultasi
    {
        $kode = KodeKonsultasi::create(['jenis' => 'Jabatan Fungsional Kepegawaian', 'kode' => 'JFK']);

        return Konsultasi::create([
            'nip' => '199001012020011001',
            'nama' => 'Pemohon Konsultasi',
            'email' => 'pemohon@example.com',
            'instansi' => 'BKN',
            'kode_id' => $kode->id,
            'jadwal' => now(),
            'tiket' => 'JFK1234',
        ]);
    }

    public function test_ticket_list_shows_unanswered_ticket()
    {
        $admin = User::factory()->create();
        $this->makeTicket();

        $response = $this->actingAs($admin)->get('/admin/konsultasi-tiket');

        $response->assertOk();
        $response->assertSee('JFK1234');
        $response->assertSee('Belum Dijawab');
    }

    public function test_admin_can_answer_ticket_and_status_updates()
    {
        $admin = User::factory()->create();
        $ticket = $this->makeTicket();

        $response = $this->actingAs($admin)->put("/admin/konsultasi/{$ticket->id}", [
            'jadwalfix' => now()->addDay()->toDateTimeString(),
            'link' => 'https://zoom.us/j/12345',
            'pic' => 'Admin Penjawab',
        ]);

        $response->assertRedirect('/admin/konsultasi');
        $ticket->refresh();
        $this->assertTrue((bool) $ticket->jawab);
        $this->assertSame('Admin Penjawab', $ticket->pic);

        $this->actingAs($admin)
            ->get('/admin/konsultasi-tiket')
            ->assertSee('Sudah Dijawab');
    }

    public function test_kode_konsultasi_relation_resolves_correct_jenis()
    {
        $ticket = $this->makeTicket();

        $this->assertSame('Jabatan Fungsional Kepegawaian', $ticket->kode_konsultasi->jenis);
    }
}
