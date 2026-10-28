<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SkeletonLoadingTest extends TestCase
{
    use RefreshDatabase;

    public function test_aset_skeleton_tersedia(): void
    {
        $this->assertFileExists(public_path('assets-flexor/css/skeleton.css'));
        $this->assertFileExists(public_path('assets-flexor/js/skeleton.js'));
    }

    public function test_layout_publik_memakai_skeleton_menggantikan_preloader(): void
    {
        $this->get('/webpusbin')->assertOk()
            ->assertSee('id="page-skeleton"', false)
            ->assertSee('assets-flexor/css/skeleton.css', false)
            ->assertSee('assets-flexor/js/skeleton.js', false)
            ->assertDontSee('id="preloader"', false);
    }

    public function test_beranda_memakai_varian_landing_dan_halaman_lain_varian_publik(): void
    {
        $this->get('/webpusbin')->assertOk()->assertSee('id="page-skeleton" data-state="loading" data-variant="landing"', false);
        $this->get('/faq')->assertOk()->assertSee('id="page-skeleton" data-state="loading" data-variant="public"', false);
    }

    public function test_layout_admin_memakai_skeleton_varian_admin(): void
    {
        $this->actingAs(User::factory()->create())->get('/admin/kegiatan')->assertOk()
            ->assertSee('id="page-skeleton"', false)
            ->assertSee('data-variant="admin"', false)
            ->assertSee('skel-side', false)
            ->assertSee('assets-flexor/js/skeleton.js', false);
    }

    public function test_chat_widget_punya_skeleton_menunggu_jawaban(): void
    {
        $this->get('/webpusbin')->assertOk()
            ->assertSee('pk-chat-wait', false)
            ->assertSee('addWaitBubble', false);
    }

    public function test_kotak_grafik_memakai_kilau_sampai_tergambar(): void
    {
        $admin = User::factory()->create();

        foreach (['/admin/absensi-statistik', '/admin/konsultasi-statistik', '/admin/pengunjung'] as $url) {
            $this->actingAs($admin)->get($url)->assertOk()->assertSee('skel skel-chart', false);
        }
    }

    public function test_semua_view_dengan_grafik_apex_memakai_kotak_skeleton(): void
    {
        // Menjaga halaman grafik baru agar ikut memakai skeleton
        $tanpaSkeleton = collect(glob(resource_path('views/admin/*/*.blade.php')))
            ->filter(fn ($f) => str_contains(file_get_contents($f), 'new ApexCharts'))
            ->reject(fn ($f) => str_contains(file_get_contents($f), 'skel skel-chart'))
            ->values()->all();

        $this->assertSame([], $tanpaSkeleton);
    }
}
