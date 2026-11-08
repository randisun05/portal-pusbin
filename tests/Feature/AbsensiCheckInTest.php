<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AbsensiCheckInTest extends TestCase
{
    use RefreshDatabase;

    protected function makeKegiatan(array $overrides = []): Kegiatan
    {
        return Kegiatan::create(array_merge([
            'nama' => 'Sosialisasi Jabatan Fungsional',
            'slug' => 'sosialisasi-jabatan-fungsional-checkin',
            'waktu' => now()->toDateTimeString(),
            'link' => 'https://zoom.us/j/123456',
            'jenis' => 'Sosialisasi',
            'image' => '',
            'status' => '1',
        ], $overrides));
    }

    protected function validPayload(Kegiatan $kegiatan, array $overrides = []): array
    {
        return array_merge([
            'nip' => '199001012020011001',
            'nama' => 'Peserta Uji',
            'kegiatan_id' => $kegiatan->id,
            'email' => 'peserta@example.com',
            'jabatan' => 'Analis SDM Aparatur',
            'instansi' => 'BKN',
            'rating' => 3,
            'saran' => 'Materinya sudah bagus, semoga durasinya bisa ditambah.',
        ], $overrides);
    }

    public function test_public_kegiatan_page_shows_qr_absensi()
    {
        $kegiatan = $this->makeKegiatan();

        $response = $this->get("/kegiatan/{$kegiatan->slug}");

        $response->assertOk();
        $response->assertSee('QR Absensi', false);
        $response->assertSee('data:image', false);
        $response->assertSee("/absensi/{$kegiatan->slug}", false);
    }

    public function test_admin_qr_absensi_page_shows_qr_for_correct_kegiatan()
    {
        $admin = User::factory()->create();
        $kegiatan = $this->makeKegiatan();

        $response = $this->actingAs($admin)->get("/admin/kegiatan/{$kegiatan->id}/qr-absensi");

        $response->assertOk();
        $response->assertSee($kegiatan->nama);
        $response->assertSee('data:image', false);
    }

    public function test_admin_qr_absensi_requires_permission()
    {
        $role = \App\Models\Role::create(['name' => 'editor-terbatas-qr', 'label' => 'Editor Terbatas']);
        $user = User::factory()->create(['role_id' => $role->id]);
        $kegiatan = $this->makeKegiatan();

        $response = $this->actingAs($user)->get("/admin/kegiatan/{$kegiatan->id}/qr-absensi");

        $response->assertForbidden();
    }

    public function test_guest_cannot_access_admin_qr_absensi()
    {
        $kegiatan = $this->makeKegiatan();

        $response = $this->get("/admin/kegiatan/{$kegiatan->id}/qr-absensi");

        $response->assertRedirect('/login');
    }

    public function test_absensi_requires_rating()
    {
        $kegiatan = $this->makeKegiatan();

        $response = $this->post("/absensi/{$kegiatan->slug}/store", $this->validPayload($kegiatan, ['rating' => null]));

        $response->assertSessionHasErrors('rating');
        $this->assertDatabaseMissing('absensis', ['nip' => '199001012020011001']);
    }

    public function test_absensi_rejects_rating_out_of_range()
    {
        $kegiatan = $this->makeKegiatan();

        $response = $this->post("/absensi/{$kegiatan->slug}/store", $this->validPayload($kegiatan, ['rating' => 9]));

        $response->assertSessionHasErrors('rating');
    }

    public function test_absensi_saves_rating_and_saran()
    {
        $kegiatan = $this->makeKegiatan();

        $this->post("/absensi/{$kegiatan->slug}/store", $this->validPayload($kegiatan));

        $this->assertDatabaseHas('absensis', [
            'nip' => '199001012020011001',
            'rating' => 3,
            'saran' => 'Materinya sudah bagus, semoga durasinya bisa ditambah.',
        ]);
    }

    public function test_saran_is_optional()
    {
        $kegiatan = $this->makeKegiatan();

        $response = $this->post("/absensi/{$kegiatan->slug}/store", $this->validPayload($kegiatan, ['saran' => null]));

        $response->assertRedirect(route('public.absensi.index'));
        $this->assertDatabaseHas('absensis', ['nip' => '199001012020011001', 'saran' => null]);
    }

    public function test_ajax_submission_returns_json_success_payload()
    {
        $kegiatan = $this->makeKegiatan();

        $response = $this->postJson("/absensi/{$kegiatan->slug}/store", $this->validPayload($kegiatan));

        $response->assertOk();
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('absensis', ['nip' => '199001012020011001']);
    }

    public function test_ajax_submission_returns_json_error_for_duplicate_nip()
    {
        $kegiatan = $this->makeKegiatan();
        Absensi::create([
            'kegiatan_id' => $kegiatan->id,
            'nip' => '199001012020011001',
            'nama' => 'Peserta Lama',
            'email' => 'lama@example.com',
            'jabatan' => 'Analis',
            'instansi' => 'BKN',
        ]);

        $response = $this->postJson("/absensi/{$kegiatan->slug}/store", $this->validPayload($kegiatan));

        $response->assertStatus(422);
        $response->assertJson(['success' => false]);
        $this->assertSame(1, Absensi::where('nip', '199001012020011001')->count());
    }

    public function test_ajax_submission_returns_json_error_when_deadline_passed()
    {
        $kegiatan = $this->makeKegiatan(['batas_presensi' => now()->subHour()->toDateTimeString()]);

        $response = $this->postJson("/absensi/{$kegiatan->slug}/store", $this->validPayload($kegiatan));

        $response->assertStatus(422);
        $response->assertJson(['success' => false]);
        $this->assertDatabaseMissing('absensis', ['nip' => '199001012020011001']);
    }

    public function test_non_ajax_submission_still_redirects_as_before()
    {
        $kegiatan = $this->makeKegiatan();

        $response = $this->post("/absensi/{$kegiatan->slug}/store", $this->validPayload($kegiatan));

        $response->assertRedirect(route('public.absensi.index'));
        $response->assertSessionHas('success');
    }
}
