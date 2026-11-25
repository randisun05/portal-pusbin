<?php

namespace Tests\Feature;

use App\Models\KodeKonsultasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KodeKonsultasiAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_edit_update_and_delete_kode()
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->post('/admin/kodekonsultasi', ['jenis' => 'Uji', 'kode' => '900'])
            ->assertRedirect('/admin/kodekonsultasi');
        $kode = KodeKonsultasi::where('kode', '900')->firstOrFail();

        $this->actingAs($admin)->get("/admin/kodekonsultasi/{$kode->id}/edit")
            ->assertOk()->assertSee('Uji');

        $this->actingAs($admin)->put("/admin/kodekonsultasi/{$kode->id}", ['jenis' => 'Uji Ubah', 'kode' => '901'])
            ->assertRedirect('/admin/kodekonsultasi');
        $this->assertDatabaseHas('kode_konsultasis', ['id' => $kode->id, 'jenis' => 'Uji Ubah', 'kode' => '901']);

        $this->actingAs($admin)->delete("/admin/kodekonsultasi/{$kode->id}")
            ->assertRedirect('/admin/kodekonsultasi');
        $this->assertDatabaseMissing('kode_konsultasis', ['id' => $kode->id]);
    }

    public function test_sidebar_links_to_kode_konsultasi_for_permitted_admin()
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->get('/admin')
            ->assertOk()
            ->assertSee('href="/admin/kodekonsultasi"', false);
    }
}
