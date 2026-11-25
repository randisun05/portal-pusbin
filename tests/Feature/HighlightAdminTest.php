<?php

namespace Tests\Feature;

use App\Models\highlight as Highlight;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HighlightAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_migration_seeds_default_content_for_all_three_groups()
    {
        $this->assertSame(3, Highlight::group(Highlight::GROUP_HERO)->count());
        $this->assertSame(3, Highlight::group(Highlight::GROUP_ABOUT)->count());
        $this->assertSame(4, Highlight::group(Highlight::GROUP_FUNGSI)->count());
    }

    public function test_admin_can_add_highlight_to_a_group()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/highlight', [
            'group' => Highlight::GROUP_FUNGSI,
            'name' => 'Layanan Baru',
            'desc' => 'Deskripsi layanan baru.',
            'icon' => 'bi-star',
            'link' => '/layanan-baru',
        ]);

        $response->assertRedirect('/admin/highlight?group=' . Highlight::GROUP_FUNGSI);
        $this->assertDatabaseHas('highlights', [
            'group' => Highlight::GROUP_FUNGSI,
            'name' => 'Layanan Baru',
            'link' => '/layanan-baru',
        ]);
    }

    public function test_admin_can_update_highlight()
    {
        $admin = User::factory()->create();
        $item = Highlight::group(Highlight::GROUP_HERO)->first();

        $response = $this->actingAs($admin)->put("/admin/highlight/{$item->id}", [
            'group' => Highlight::GROUP_HERO,
            'name' => 'Judul Diubah',
            'desc' => 'Deskripsi diubah.',
            'icon' => 'bi-gear',
        ]);

        $response->assertRedirect('/admin/highlight?group=' . Highlight::GROUP_HERO);
        $this->assertDatabaseHas('highlights', [
            'id' => $item->id,
            'name' => 'Judul Diubah',
            'icon' => 'bi-gear',
        ]);
    }

    public function test_admin_can_delete_highlight()
    {
        $admin = User::factory()->create();
        $item = Highlight::group(Highlight::GROUP_ABOUT)->first();

        $response = $this->actingAs($admin)->delete("/admin/highlight/{$item->id}");

        $response->assertRedirect('/admin/highlight?group=' . Highlight::GROUP_ABOUT);
        $this->assertDatabaseMissing('highlights', ['id' => $item->id]);
    }

    public function test_invalid_group_is_rejected()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/highlight', [
            'group' => 'tidak-ada',
            'name' => 'X',
            'desc' => 'Y',
        ]);

        $response->assertSessionHasErrors('group');
    }

    public function test_guest_cannot_access_admin_highlight_routes()
    {
        $response = $this->get('/admin/highlight');

        $response->assertRedirect('/login');
    }

    public function test_role_without_manage_highlight_permission_is_denied()
    {
        $role = Role::create(['name' => 'editor-terbatas-highlight', 'label' => 'Editor Terbatas']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($user)->get('/admin/highlight');

        $response->assertForbidden();
    }
}
