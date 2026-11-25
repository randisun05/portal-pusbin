<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * BUG-07: email admin tidak divalidasi formatnya; BUG-08: admin dapat menghapus
 * akunnya sendiri (risiko terkunci dari panel bila itu satu-satunya Super Admin).
 */
class AdminUserValidasiTest extends TestCase
{
    use RefreshDatabase;

    private function superAdmin(): User
    {
        $role = Role::create(['name' => Role::SUPER_ADMIN, 'label' => 'Super Admin']);

        return User::factory()->create(['role_id' => $role->id]);
    }

    public function test_email_admin_harus_berformat_email()
    {
        $admin = $this->superAdmin();

        $this->actingAs($admin)->post('/admin/register', [
            'name' => 'Uji', 'username' => 'uji_user', 'email' => 'bukan-email', 'password' => 'UjiPass#2026',
        ])->assertSessionHasErrors('email');

        $this->assertDatabaseMissing('users', ['username' => 'uji_user']);
    }

    public function test_admin_tidak_dapat_menghapus_akun_sendiri()
    {
        $admin = $this->superAdmin();

        $this->actingAs($admin)->delete("/admin/register/{$admin->id}")
            ->assertRedirect('/admin/register')->assertSessionHas('error');

        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_admin_dapat_menghapus_akun_lain()
    {
        $admin = $this->superAdmin();
        $lain = User::factory()->create();

        $this->actingAs($admin)->delete("/admin/register/{$lain->id}")->assertRedirect('/admin/register');

        $this->assertDatabaseMissing('users', ['id' => $lain->id]);
    }
}
