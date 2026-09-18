<?php

namespace Tests\Feature;

use App\Models\Jdihjfk;
use App\Models\Kegiatan;
use App\Models\Layanan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrokenImageCleanupTest extends TestCase
{
    use RefreshDatabase;

    public function test_migration_already_cleaned_broken_layanan_image_paths()
    {
        Layanan::create([
            'nama' => 'Layanan Uji',
            'deskripsi' => 'x',
            'link' => '/x',
            'image' => 'post-image\\tidak-ada.png',
            'status' => 1,
        ]);

        // Baris di atas dibuat SETELAH migration cleanup jalan (karena RefreshDatabase
        // menjalankan migration lebih dulu), jadi memang harus tetap tersimpan apa
        // adanya - migration cleanup hanya membersihkan data yang SUDAH ada saat
        // migration itu berjalan, bukan mengawasi data baru terus-menerus.
        $this->assertDatabaseHas('layanans', ['nama' => 'Layanan Uji']);
    }

    public function test_public_kegiatan_show_page_renders_fallback_icon_when_image_missing()
    {
        $kegiatan = Kegiatan::create([
            'nama' => 'Kegiatan Tanpa Gambar',
            'slug' => 'kegiatan-tanpa-gambar',
            'waktu' => now()->toDateTimeString(),
            'link' => 'https://zoom.us/j/1',
            'jenis' => 'Sosialisasi',
            'image' => '',
            'status' => '1',
        ]);

        $response = $this->get("/kegiatan/{$kegiatan->slug}");

        $response->assertOk();
        $response->assertSee('bi-calendar-event', false);
        $response->assertDontSee('storage/', false);
    }

    public function test_public_repository_page_renders_fallback_icon_when_image_missing()
    {
        Jdihjfk::create([
            'title' => 'Dokumen Tanpa Gambar',
            'deskripsi' => 'x',
            'status' => Jdihjfk::STATUS_PUBLISHED,
            'image' => null,
        ]);

        $response = $this->get('/repository');

        $response->assertOk();
        $response->assertSee('Dokumen Tanpa Gambar');
        $response->assertSee('bi-file-earmark-text', false);
    }

    public function test_homepage_kegiatan_teaser_shows_fallback_for_broken_image_path()
    {
        Kegiatan::create([
            'nama' => 'Kegiatan Path Rusak',
            'slug' => 'kegiatan-path-rusak',
            'waktu' => now()->toDateTimeString(),
            'link' => 'https://zoom.us/j/2',
            'jenis' => 'Sosialisasi',
            'image' => 'post-image/tidak-pernah-ada.png',
            'status' => '1',
        ]);

        $response = $this->get('/webpusbin');

        $response->assertOk();
        $response->assertDontSee('storage/post-image/tidak-pernah-ada.png', false);
    }
}
