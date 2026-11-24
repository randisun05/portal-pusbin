<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * BUG-01: kuota pembatas laju (throttle) tadinya dipakai bersama oleh semua
 * rute publik untuk satu IP, sehingga reaksi/chat bisa menghabiskan jatah
 * kirim komentar atau formulir kontak. Tiap rute kini punya kunci sendiri.
 */
class ThrottleTerpisahTest extends TestCase
{
    use RefreshDatabase;

    public function test_kuota_reaksi_tidak_menghabiskan_kuota_formulir_kontak()
    {
        $category = Category::create(['name' => 'Umum', 'slug' => 'umum']);
        $post = Post::factory()->create(['category_id' => $category->id]);

        for ($i = 0; $i < 3; $i++) {
            $this->postJson("/publikasi/{$post->slug}/react", ['type' => 'suka'])->assertOk();
        }

        $data = ['nama' => 'Uji', 'email' => 'uji@example.test', 'subjek' => 's', 'pesan' => 'p'];
        for ($i = 0; $i < 5; $i++) {
            $this->post('/about/kontak-kami', $data)->assertStatus(302);
        }
        $this->post('/about/kontak-kami', $data)->assertStatus(429);
    }
}
