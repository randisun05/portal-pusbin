<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_for_admin_routes()
    {
        $response = $this->get('/admin/jadwalukom');

        $response->assertRedirect('/login');
    }

    public function test_admin_can_login()
    {
        $user = User::factory()->create(['password' => bcrypt('rahasia123')]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'rahasia123',
        ]);

        $response->assertRedirect();
        $this->assertAuthenticatedAs($user);
    }

    public function test_role_without_permission_is_denied_access()
    {
        $role = Role::create(['name' => 'staf-terbatas', 'label' => 'Staf Terbatas']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($user)->get('/admin/jadwalukom');

        $response->assertForbidden();
    }

    public function test_role_with_permission_is_granted_access()
    {
        $permission = Permission::create([
            'slug' => 'manage-jadwalukom',
            'label' => 'Kelola Jadwal Ujikom',
            'grup' => 'Operasional',
        ]);
        $role = Role::create(['name' => 'staf-jadwal', 'label' => 'Staf Jadwal']);
        $role->permissions()->attach($permission->id);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($user)->get('/admin/jadwalukom');

        $response->assertOk();
    }

    public function test_revoking_permission_immediately_blocks_already_logged_in_user()
    {
        $permission = Permission::create([
            'slug' => 'manage-jadwalukom',
            'label' => 'Kelola Jadwal Ujikom',
            'grup' => 'Operasional',
        ]);
        $role = Role::create(['name' => 'staf-jadwal', 'label' => 'Staf Jadwal']);
        $role->permissions()->attach($permission->id);
        $user = User::factory()->create(['role_id' => $role->id]);

        $this->actingAs($user)->get('/admin/jadwalukom')->assertOk();

        $role->permissions()->detach($permission->id);

        // Simulasikan permintaan HTTP baru yang benar-benar terpisah (seperti
        // di kehidupan nyata) dengan mengambil ulang user dari database,
        // bukan memakai objek PHP yang relasinya sudah ter-cache dari
        // permintaan sebelumnya di test yang sama.
        $this->actingAs(User::find($user->id))->get('/admin/jadwalukom')->assertForbidden();
    }

    public function test_user_without_role_has_full_backward_compatible_access()
    {
        $user = User::factory()->create(['role_id' => null]);

        $response = $this->actingAs($user)->get('/admin/jadwalukom');

        $response->assertOk();
    }
}
