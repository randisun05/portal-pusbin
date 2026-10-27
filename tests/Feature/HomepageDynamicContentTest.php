<?php

namespace Tests\Feature;

use App\Models\highlight as Highlight;
use App\Models\Profil;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageDynamicContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_shows_seeded_default_highlight_content()
    {
        $response = $this->get('/webpusbin');

        $response->assertOk();
        // Hero
        $response->assertSee('Uji Kompetensi');
        // About
        $response->assertSee('Dilaksanakan 4 Periode Dalam 1 Tahun');
        // Fungsi
        $response->assertSee('Survei Kepuasan');
    }

    public function test_homepage_reflects_admin_edited_highlight_content()
    {
        $item = Highlight::group(Highlight::GROUP_FUNGSI)->first();
        $item->update(['name' => 'Fitur Baru Kustom', 'desc' => 'Deskripsi kustom oleh admin.']);

        $response = $this->get('/webpusbin');

        $response->assertOk();
        $response->assertSee('Fitur Baru Kustom');
        $response->assertSee('Deskripsi kustom oleh admin.');
    }

    public function test_homepage_reflects_admin_edited_profil_hero_fields()
    {
        Profil::create([
            'hero_judul' => 'Judul Kustom Direktorat',
            'hero_deskripsi' => 'Deskripsi kustom hero.',
            'about_judul' => 'Judul Tentang Kustom',
            'stat_label_organisasi' => 'Jumlah Pegawai',
        ]);

        $response = $this->get('/webpusbin');

        $response->assertOk();
        $response->assertSee('Judul Kustom Direktorat');
        $response->assertSee('Deskripsi kustom hero.');
        $response->assertSee('Judul Tentang Kustom');
        $response->assertSee('Jumlah Pegawai');
    }

    public function test_homepage_falls_back_to_default_text_when_highlight_group_is_empty()
    {
        Highlight::group(Highlight::GROUP_FUNGSI)->delete();

        $response = $this->get('/webpusbin');

        $response->assertOk();
        $response->assertSee('Survei Kepuasan');
    }

    public function test_admin_can_update_profil_homepage_fields()
    {
        $admin = \App\Models\User::factory()->create();

        $response = $this->actingAs($admin)->put('/admin/profil', [
            'hero_judul' => 'Judul Baru',
            'stat_label_organisasi' => 'Label Baru',
        ]);

        $response->assertRedirect('/admin/profil');
        $this->assertDatabaseHas('profils', [
            'hero_judul' => 'Judul Baru',
            'stat_label_organisasi' => 'Label Baru',
        ]);
    }
}
