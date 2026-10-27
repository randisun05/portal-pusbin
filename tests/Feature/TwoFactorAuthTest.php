<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\TwoFactorAuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PragmaRX\Google2FA\Google2FA;
use Tests\TestCase;

class TwoFactorAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_without_2fa_enabled_works_as_before()
    {
        $user = User::factory()->create(['password' => bcrypt('rahasia123')]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'rahasia123',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_with_2fa_enabled_redirects_to_challenge_instead_of_logging_in()
    {
        $user = User::factory()->create([
            'password' => bcrypt('rahasia123'),
            'two_factor_secret' => 'SECRETKEY123456',
            'two_factor_enabled_at' => now(),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'rahasia123',
        ]);

        $response->assertRedirect('/login/verifikasi-2fa');
        $this->assertGuest();
    }

    public function test_correct_totp_code_completes_login()
    {
        $secret = (new Google2FA())->generateSecretKey();
        $user = User::factory()->create([
            'password' => bcrypt('rahasia123'),
            'two_factor_secret' => $secret,
            'two_factor_enabled_at' => now(),
        ]);

        $this->post('/login', ['email' => $user->email, 'password' => 'rahasia123']);

        $validCode = (new Google2FA())->getCurrentOtp($secret);

        $response = $this->post('/login/verifikasi-2fa', ['code' => $validCode]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
    }

    public function test_wrong_totp_code_does_not_log_in()
    {
        $secret = (new Google2FA())->generateSecretKey();
        $user = User::factory()->create([
            'password' => bcrypt('rahasia123'),
            'two_factor_secret' => $secret,
            'two_factor_enabled_at' => now(),
        ]);

        $this->post('/login', ['email' => $user->email, 'password' => 'rahasia123']);

        $response = $this->post('/login/verifikasi-2fa', ['code' => '000000']);

        $response->assertSessionHas('loginerror');
        $this->assertGuest();
    }

    public function test_challenge_page_redirects_to_login_without_pending_session()
    {
        $response = $this->get('/login/verifikasi-2fa');

        $response->assertRedirect('/login');
    }

    public function test_recovery_code_can_be_used_once_to_login()
    {
        $twoFactor = app(TwoFactorAuthService::class);
        $recovery = $twoFactor->generateRecoveryCodes(3);

        $user = User::factory()->create([
            'password' => bcrypt('rahasia123'),
            'two_factor_secret' => (new Google2FA())->generateSecretKey(),
            'two_factor_enabled_at' => now(),
            'two_factor_recovery_codes' => $recovery['hashed'],
        ]);

        $this->post('/login', ['email' => $user->email, 'password' => 'rahasia123']);

        $response = $this->post('/login/verifikasi-2fa', ['code' => $recovery['plain'][0]]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);

        $this->assertCount(2, $user->fresh()->two_factor_recovery_codes);
    }

    public function test_used_recovery_code_cannot_be_reused()
    {
        $twoFactor = app(TwoFactorAuthService::class);
        $recovery = $twoFactor->generateRecoveryCodes(2);

        $user = User::factory()->create([
            'password' => bcrypt('rahasia123'),
            'two_factor_secret' => (new Google2FA())->generateSecretKey(),
            'two_factor_enabled_at' => now(),
            'two_factor_recovery_codes' => $recovery['hashed'],
        ]);

        $this->post('/login', ['email' => $user->email, 'password' => 'rahasia123']);
        $this->post('/login/verifikasi-2fa', ['code' => $recovery['plain'][0]]);
        \Illuminate\Support\Facades\Auth::logout();

        $this->post('/login', ['email' => $user->email, 'password' => 'rahasia123']);
        $response = $this->post('/login/verifikasi-2fa', ['code' => $recovery['plain'][0]]);

        $response->assertSessionHas('loginerror');
        $this->assertGuest();
    }

    public function test_admin_can_enable_2fa_end_to_end()
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->post('/admin/two-factor/enable')->assertRedirect('/admin/two-factor');

        $secret = session('2fa:pending:secret');
        $this->assertNotEmpty($secret);

        $validCode = (new Google2FA())->getCurrentOtp($secret);

        $response = $this->actingAs($admin)->post('/admin/two-factor/confirm', ['code' => $validCode]);

        $response->assertRedirect('/admin/two-factor');
        $this->assertTrue($admin->fresh()->hasTwoFactorEnabled());
    }

    public function test_confirm_fails_with_wrong_code_and_does_not_enable_2fa()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin)->post('/admin/two-factor/enable');

        $response = $this->actingAs($admin)->post('/admin/two-factor/confirm', ['code' => '000000']);

        $response->assertRedirect('/admin/two-factor');
        $response->assertSessionHas('error');
        $this->assertFalse($admin->fresh()->hasTwoFactorEnabled());
    }

    public function test_admin_can_disable_2fa_with_correct_password()
    {
        $admin = User::factory()->create([
            'password' => bcrypt('rahasia123'),
            'two_factor_secret' => 'SECRETKEY123456',
            'two_factor_enabled_at' => now(),
        ]);

        $response = $this->actingAs($admin)->post('/admin/two-factor/disable', ['password' => 'rahasia123']);

        $response->assertRedirect('/admin/two-factor');
        $this->assertFalse($admin->fresh()->hasTwoFactorEnabled());
    }

    public function test_disable_fails_with_wrong_password()
    {
        $admin = User::factory()->create([
            'password' => bcrypt('rahasia123'),
            'two_factor_secret' => 'SECRETKEY123456',
            'two_factor_enabled_at' => now(),
        ]);

        $response = $this->actingAs($admin)->post('/admin/two-factor/disable', ['password' => 'salah']);

        $response->assertSessionHas('error');
        $this->assertTrue($admin->fresh()->hasTwoFactorEnabled());
    }

    public function test_two_factor_secret_is_stored_encrypted_at_rest()
    {
        $admin = User::factory()->create([
            'two_factor_secret' => 'PLAINSECRETVALUE',
            'two_factor_enabled_at' => now(),
        ]);

        $raw = \Illuminate\Support\Facades\DB::table('users')->where('id', $admin->id)->value('two_factor_secret');

        $this->assertNotEquals('PLAINSECRETVALUE', $raw);
        $this->assertSame('PLAINSECRETVALUE', $admin->fresh()->two_factor_secret);
    }
}
