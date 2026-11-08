<?php

namespace Tests\Feature;

use App\Mail\SendEmail;
use App\Models\KodeKonsultasi;
use App\Models\Konsultasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class KonsultasiTiketPublikTest extends TestCase
{
    use RefreshDatabase;

    protected function payload(array $override = []): array
    {
        $kode = KodeKonsultasi::firstOrCreate(['kode' => '001'], ['jenis' => 'Jabatan Fungsional Kepegawaian']);

        return array_merge([
            'nip' => '199001012020011001',
            'nama' => 'Pemohon Tiket',
            'email' => 'pemohon@example.com',
            'instansi' => 'BKN',
            'kode_id' => $kode->id,
            'deskripsi' => 'Bagaimana cara mengajukan kenaikan jenjang jabatan?',
            'jadwal' => now()->addDays(3)->toDateString(),
        ], $override);
    }

    public function test_form_is_publicly_reachable_and_lists_kode(): void
    {
        KodeKonsultasi::create(['jenis' => 'Uji Kompetensi', 'kode' => '002']);

        $this->get('/konsultasi/usul')->assertOk()->assertSee('Uji Kompetensi')->assertSee('KIRIM USULAN');
    }

    public function test_submit_creates_ticket_sends_email_and_can_be_looked_up(): void
    {
        Mail::fake();

        $response = $this->post('/konsultasi/usul', $this->payload());

        $ticket = Konsultasi::firstOrFail();
        $this->assertMatchesRegularExpression('/^001\d{8}$/', $ticket->tiket);
        $this->assertSame('Bagaimana cara mengajukan kenaikan jenjang jabatan?', $ticket->deskripsi);
        $this->assertSame(0, (int) $ticket->jawab);
        $response->assertRedirect('/konsultasi/tiket?tiket=' . $ticket->tiket);

        Mail::assertSent(SendEmail::class, fn ($m) => $m->hasTo('pemohon@example.com'));

        $this->get('/konsultasi/tiket?tiket=' . $ticket->tiket)->assertOk()->assertSee($ticket->tiket);
        $this->get('/konsultasi/jadwal?search=' . $ticket->tiket)->assertOk()->assertSee('Tiket Belum Dijawab');
    }

    public function test_ticket_is_still_created_when_email_fails(): void
    {
        Mail::shouldReceive('to')->andThrow(new \RuntimeException('smtp down'));

        $this->post('/konsultasi/usul', $this->payload())->assertRedirect();

        $this->assertSame(1, Konsultasi::count());
    }

    public function test_validation_rejects_bad_input(): void
    {
        $this->post('/konsultasi/usul', $this->payload(['nip' => '123', 'email' => 'bukan-email', 'deskripsi' => '', 'kode_id' => 999, 'jadwal' => now()->subDay()->toDateString()]))
            ->assertSessionHasErrors(['nip', 'email', 'deskripsi', 'kode_id', 'jadwal']);

        $this->assertSame(0, Konsultasi::count());
    }

    public function test_honeypot_submission_is_silently_dropped(): void
    {
        $this->post('/konsultasi/usul', $this->payload(['website' => 'http://spam.example']))->assertRedirect('/konsultasi/usul');

        $this->assertSame(0, Konsultasi::count());
    }

    public function test_admin_can_no_longer_create_tickets_through_legacy_endpoint(): void
    {
        $admin = \App\Models\User::factory()->create();

        $this->actingAs($admin)->post('/admin/konsultasi', $this->payload())->assertStatus(405);
    }

    public function test_admin_answer_form_shows_applicant_question(): void
    {
        $admin = \App\Models\User::factory()->create();
        $this->post('/konsultasi/usul', $this->payload());
        $ticket = Konsultasi::firstOrFail();

        $this->actingAs($admin)->get('/admin/konsultasi/' . $ticket->id . '/edit')
            ->assertOk()->assertSee('Bagaimana cara mengajukan kenaikan jenjang jabatan?');
    }
}
