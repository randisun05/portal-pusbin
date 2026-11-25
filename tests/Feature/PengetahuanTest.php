<?php

namespace Tests\Feature;

use App\Models\Pengetahuan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PengetahuanTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_knowledge_item()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/pengetahuan', [
            'judul' => 'Syarat Pendaftaran Uji Kompetensi',
            'isi' => 'Peserta wajib memiliki NIP aktif dan surat tugas dari instansi.',
            'kategori' => 'Uji Kompetensi',
            'kata_kunci' => 'ukom, syarat, daftar',
            'aktif' => '1',
        ]);

        $response->assertRedirect('/admin/pengetahuan');
        $this->assertDatabaseHas('pengetahuans', [
            'judul' => 'Syarat Pendaftaran Uji Kompetensi',
            'kategori' => 'Uji Kompetensi',
            'aktif' => true,
        ]);
    }

    public function test_unchecked_aktif_checkbox_saves_as_inactive()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/pengetahuan', [
            'judul' => 'Draft Belum Siap',
            'isi' => 'Isi belum final.',
        ]);

        $response->assertRedirect('/admin/pengetahuan');
        $this->assertDatabaseHas('pengetahuans', [
            'judul' => 'Draft Belum Siap',
            'aktif' => false,
        ]);
    }

    public function test_admin_can_update_knowledge_item()
    {
        $admin = User::factory()->create();
        $item = Pengetahuan::create(['judul' => 'Judul Lama', 'isi' => 'Isi lama.', 'aktif' => true]);

        $response = $this->actingAs($admin)->put("/admin/pengetahuan/{$item->id}", [
            'judul' => 'Judul Baru',
            'isi' => 'Isi baru.',
            'aktif' => '1',
        ]);

        $response->assertRedirect('/admin/pengetahuan');
        $this->assertDatabaseHas('pengetahuans', ['id' => $item->id, 'judul' => 'Judul Baru']);
    }

    public function test_admin_can_delete_knowledge_item()
    {
        $admin = User::factory()->create();
        $item = Pengetahuan::create(['judul' => 'Akan Dihapus', 'isi' => 'x', 'aktif' => true]);

        $response = $this->actingAs($admin)->delete("/admin/pengetahuan/{$item->id}");

        $response->assertRedirect('/admin/pengetahuan');
        $this->assertDatabaseMissing('pengetahuans', ['id' => $item->id]);
    }

    public function test_guest_cannot_access_admin_pengetahuan_routes()
    {
        $response = $this->get('/admin/pengetahuan');

        $response->assertRedirect('/login');
    }

    public function test_role_without_manage_pengetahuan_permission_is_denied()
    {
        $role = Role::create(['name' => 'editor-terbatas-pengetahuan', 'label' => 'Editor Terbatas']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($user)->get('/admin/pengetahuan');

        $response->assertForbidden();
    }

    public function test_active_scope_only_returns_active_items_ordered_by_urutan()
    {
        Pengetahuan::create(['judul' => 'Kedua', 'isi' => 'x', 'aktif' => true, 'urutan' => 2]);
        Pengetahuan::create(['judul' => 'Nonaktif', 'isi' => 'x', 'aktif' => false, 'urutan' => 0]);
        Pengetahuan::create(['judul' => 'Pertama', 'isi' => 'x', 'aktif' => true, 'urutan' => 1]);

        $active = Pengetahuan::active()->pluck('judul');

        $this->assertSame(['Pertama', 'Kedua'], $active->all());
    }

    public function test_chat_ask_endpoint_still_works_with_knowledge_items_present()
    {
        Pengetahuan::create(['judul' => 'Jadwal Ujikom', 'isi' => 'Ujikom dilaksanakan 4 periode setahun.', 'aktif' => true]);

        $response = $this->postJson('/chat/ask', ['question' => 'Kapan jadwal ujikom?']);

        $response->assertOk();
        $response->assertJson(['answer' => null]);
    }

    public function test_homepage_chat_widget_includes_active_knowledge_but_not_inactive()
    {
        Pengetahuan::create(['judul' => 'Materi Aktif Unik123', 'isi' => 'Isi materi aktif.', 'aktif' => true]);
        Pengetahuan::create(['judul' => 'Materi Nonaktif Unik456', 'isi' => 'Isi materi nonaktif.', 'aktif' => false]);

        $response = $this->get('/webpusbin');

        $response->assertOk();
        $response->assertSee('Materi Aktif Unik123');
        $response->assertDontSee('Materi Nonaktif Unik456');
    }
}
