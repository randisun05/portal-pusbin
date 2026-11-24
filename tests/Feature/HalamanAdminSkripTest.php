<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * BUG-04/05: sisa skrip salin-tempel di halaman admin menimbulkan error JS
 * (deklarasi ganda, elemen #title tidak ada) dan favicon admin mengarah ke berkas yang tidak ada.
 */
class HalamanAdminSkripTest extends TestCase
{
    use RefreshDatabase;

    public function test_edit_publikasi_tidak_memuat_skrip_rusak()
    {
        $admin = User::factory()->create();
        $category = Category::create(['name' => 'Umum', 'slug' => 'umum']);
        $post = Post::factory()->create(['category_id' => $category->id]);

        $html = $this->actingAs($admin)->get("/admin/publikasi/{$post->id}/edit")->assertOk()->getContent();

        $this->assertSame(0, substr_count($html, 'const title'));
        $this->assertStringNotContainsString('addEventListner', $html);
        $this->assertStringContainsString('trix-files-accept', $html);
    }

    public function test_form_kode_konsultasi_tidak_memuat_skrip_slug_yatim()
    {
        $admin = User::factory()->create();

        $html = $this->actingAs($admin)->get('/admin/kodekonsultasi/create')->assertOk()->getContent();

        $this->assertStringNotContainsString("querySelector('#title')", $html);
    }

    public function test_form_edit_kode_konsultasi_tidak_memuat_skrip_rusak()
    {
        $admin = User::factory()->create();
        $kode = \App\Models\KodeKonsultasi::create(['jenis' => 'Uji', 'kode' => 'UJ']);

        $html = $this->actingAs($admin)->get("/admin/kodekonsultasi/{$kode->id}/edit")->assertOk()->getContent();

        $this->assertSame(0, substr_count($html, 'const title'));
    }

    public function test_tabel_field_formulir_dibungkus_table_responsive_untuk_ponsel()
    {
        $admin = User::factory()->create();
        $formulir = \App\Models\Formulir::create(['judul' => 'F1', 'slug' => 'f1', 'status' => '1']);
        $this->actingAs($admin)->post("/admin/formulir/{$formulir->id}/field", ['label' => 'Nama', 'tipe' => 'text']);

        $html = $this->actingAs($admin)->get("/admin/formulir/{$formulir->id}/field")->assertOk()->getContent();

        $this->assertMatchesRegularExpression('/<div class="table-responsive">\s*<table/', $html);
    }

    public function test_favicon_admin_menunjuk_berkas_yang_ada()
    {
        $admin = User::factory()->create();

        $html = $this->actingAs($admin)->get('/admin/kodekonsultasi/create')->getContent();

        $this->assertStringNotContainsString('logo-pusbin.png', $html);
        $this->assertFileExists(public_path('assets/img/logo/favicon.png'));
    }
}
