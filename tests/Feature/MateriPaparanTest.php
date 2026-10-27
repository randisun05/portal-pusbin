<?php

namespace Tests\Feature;

use App\Models\Kegiatan;
use App\Models\MateriPaparan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MateriPaparanTest extends TestCase
{
    use RefreshDatabase;

    protected function makeKegiatan(): Kegiatan
    {
        return Kegiatan::create([
            'nama' => 'Seminar Zoom Jabatan Fungsional',
            'slug' => 'seminar-zoom-jabatan-fungsional',
            'waktu' => now()->toDateTimeString(),
            'link' => 'https://zoom.us/j/123456',
            'jenis' => 'Sosialisasi',
            'image' => 'post-image/dummy.png',
            'status' => '1',
        ]);
    }

    public function test_admin_can_upload_materi_paparan()
    {
        Storage::fake('local');
        $admin = User::factory()->create();
        $kegiatan = $this->makeKegiatan();
        $file = UploadedFile::fake()->create('paparan.pdf', 500, 'application/pdf');

        $response = $this->actingAs($admin)->post("/admin/kegiatan/{$kegiatan->id}/materi", [
            'judul' => 'Materi Sesi 1',
            'file' => $file,
            'keterangan' => 'Slide pembuka',
        ]);

        $response->assertRedirect("/admin/kegiatan/{$kegiatan->id}/materi");
        $this->assertDatabaseHas('materi_paparans', [
            'kegiatan_id' => $kegiatan->id,
            'judul' => 'Materi Sesi 1',
            'keterangan' => 'Slide pembuka',
        ]);

        $materi = MateriPaparan::first();
        Storage::disk('local')->assertExists($materi->file);
    }

    public function test_upload_rejects_disallowed_file_type()
    {
        $admin = User::factory()->create();
        $kegiatan = $this->makeKegiatan();
        $file = UploadedFile::fake()->create('paparan.exe', 100, 'application/octet-stream');

        $response = $this->actingAs($admin)->post("/admin/kegiatan/{$kegiatan->id}/materi", [
            'judul' => 'Materi Berbahaya',
            'file' => $file,
        ]);

        $response->assertSessionHasErrors('file');
        $this->assertDatabaseMissing('materi_paparans', ['judul' => 'Materi Berbahaya']);
    }

    public function test_admin_materi_index_lists_uploaded_files()
    {
        $admin = User::factory()->create();
        $kegiatan = $this->makeKegiatan();
        MateriPaparan::create([
            'kegiatan_id' => $kegiatan->id,
            'judul' => 'Materi Sesi 1',
            'file' => 'materi-paparan/dummy.pdf',
            'urutan' => 0,
        ]);

        $response = $this->actingAs($admin)->get("/admin/kegiatan/{$kegiatan->id}/materi");

        $response->assertOk();
        $response->assertSee('Materi Sesi 1');
    }

    public function test_guest_cannot_access_admin_materi_routes()
    {
        $kegiatan = $this->makeKegiatan();

        $response = $this->get("/admin/kegiatan/{$kegiatan->id}/materi");

        $response->assertRedirect('/login');
    }

    public function test_role_without_manage_kegiatan_permission_is_denied()
    {
        $role = Role::create(['name' => 'editor-terbatas', 'label' => 'Editor Terbatas']);
        $user = User::factory()->create(['role_id' => $role->id]);
        $kegiatan = $this->makeKegiatan();

        $response = $this->actingAs($user)->get("/admin/kegiatan/{$kegiatan->id}/materi");

        $response->assertForbidden();
    }

    public function test_admin_can_delete_materi_paparan()
    {
        Storage::fake('local');
        $admin = User::factory()->create();
        $kegiatan = $this->makeKegiatan();
        $storedPath = UploadedFile::fake()->create('paparan.pdf', 200)->store('materi-paparan');
        $materi = MateriPaparan::create([
            'kegiatan_id' => $kegiatan->id,
            'judul' => 'Materi Sesi 1',
            'file' => $storedPath,
            'urutan' => 0,
        ]);

        $response = $this->actingAs($admin)->delete("/admin/kegiatan/{$kegiatan->id}/materi/{$materi->id}");

        $response->assertRedirect("/admin/kegiatan/{$kegiatan->id}/materi");
        $this->assertDatabaseMissing('materi_paparans', ['id' => $materi->id]);
        Storage::disk('local')->assertMissing($storedPath);
    }

    public function test_public_kegiatan_page_shows_downloadable_materi()
    {
        $kegiatan = $this->makeKegiatan();
        MateriPaparan::create([
            'kegiatan_id' => $kegiatan->id,
            'judul' => 'Slide Pengantar Jabatan Fungsional',
            'file' => 'materi-paparan/slide.pdf',
            'urutan' => 0,
        ]);

        $response = $this->get("/kegiatan/{$kegiatan->slug}");

        $response->assertOk();
        $response->assertSee('Slide Pengantar Jabatan Fungsional');
        $response->assertSee('/storage/materi-paparan/slide.pdf', false);
    }

    public function test_public_kegiatan_page_hides_materi_section_when_empty()
    {
        $kegiatan = $this->makeKegiatan();

        $response = $this->get("/kegiatan/{$kegiatan->slug}");

        $response->assertOk();
        $response->assertDontSee('Materi Paparan');
    }
}
