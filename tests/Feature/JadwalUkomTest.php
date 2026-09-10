<?php

namespace Tests\Feature;

use App\Models\JadwalUkom;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JadwalUkomTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_jadwal_ukom()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/jadwalukom', [
            'periode' => 'I',
            'bulan' => 'Februari',
            'batasdaftar' => 'Akhir Desember Tahun Sebelumnya',
        ]);

        $response->assertRedirect('/admin/jadwalukom');
        $this->assertDatabaseHas('jadwal_ukoms', ['periode' => 'I', 'bulan' => 'Februari']);
    }

    public function test_admin_can_update_jadwal_ukom()
    {
        $admin = User::factory()->create();
        $jadwal = JadwalUkom::create(['periode' => 'I', 'bulan' => 'Februari', 'batasdaftar' => 'Lama']);

        $response = $this->actingAs($admin)->put("/admin/jadwalukom/{$jadwal->id}", [
            'periode' => 'I',
            'bulan' => 'Maret',
            'batasdaftar' => 'Baru',
        ]);

        $response->assertRedirect('/admin/jadwalukom');
        $this->assertDatabaseHas('jadwal_ukoms', ['id' => $jadwal->id, 'bulan' => 'Maret', 'batasdaftar' => 'Baru']);
    }

    public function test_admin_can_delete_jadwal_ukom()
    {
        $admin = User::factory()->create();
        $jadwal = JadwalUkom::create(['periode' => 'I', 'bulan' => 'Februari', 'batasdaftar' => 'Lama']);

        $response = $this->actingAs($admin)->delete("/admin/jadwalukom/{$jadwal->id}");

        $response->assertRedirect('/admin/jadwalukom');
        $this->assertDatabaseMissing('jadwal_ukoms', ['id' => $jadwal->id]);
    }

    public function test_create_and_edit_forms_render()
    {
        $admin = User::factory()->create();
        $jadwal = JadwalUkom::create(['periode' => 'I', 'bulan' => 'Februari', 'batasdaftar' => 'Lama']);

        $this->actingAs($admin)->get('/admin/jadwalukom/create')->assertOk();
        $this->actingAs($admin)->get("/admin/jadwalukom/{$jadwal->id}/edit")->assertOk()->assertSee('Februari');
    }
}
