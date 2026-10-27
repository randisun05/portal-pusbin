<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\SiasnSsoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SiasnSsoTest extends TestCase
{
    use RefreshDatabase;

    protected function fakeJwt(array $claims): string
    {
        $header = rtrim(strtr(base64_encode(json_encode(['alg' => 'RS256', 'typ' => 'JWT'])), '+/', '-_'), '=');
        $payload = rtrim(strtr(base64_encode(json_encode($claims)), '+/', '-_'), '=');

        return "{$header}.{$payload}.fake-signature";
    }

    public function test_service_returns_null_when_client_id_not_configured()
    {
        config(['services.siasn.mode' => 'training', 'services.siasn.sso.training.client_id' => null]);

        $service = app(SiasnSsoService::class);

        $this->assertFalse($service->isConfigured());
        $this->assertNull($service->authenticate('123', 'password'));
    }

    public function test_service_posts_correct_grant_type_and_returns_claims_on_success()
    {
        config([
            'services.siasn.mode' => 'training',
            'services.siasn.sso.training.client_id' => 'fake-client-id',
            'services.siasn.sso.training.url' => 'https://iam-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token',
        ]);

        $jwt = $this->fakeJwt(['preferred_username' => '199001012020011001', 'name' => 'Budi Santoso']);

        Http::fake([
            'iam-siasn.bkn.go.id/*' => Http::response(['access_token' => $jwt, 'token_type' => 'Bearer'], 200),
        ]);

        $service = app(SiasnSsoService::class);
        $result = $service->authenticate('199001012020011001', 'password-siasn');

        $this->assertNotNull($result);
        $this->assertSame('199001012020011001', $result['nip']);
        $this->assertSame('Budi Santoso', $result['name']);

        Http::assertSent(function ($request) {
            return $request['grant_type'] === 'password'
                && $request['client_id'] === 'fake-client-id'
                && $request['username'] === '199001012020011001'
                && $request['password'] === 'password-siasn';
        });
    }

    public function test_service_returns_null_when_bkn_rejects_credentials()
    {
        config([
            'services.siasn.mode' => 'training',
            'services.siasn.sso.training.client_id' => 'fake-client-id',
            'services.siasn.sso.training.url' => 'https://iam-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token',
        ]);

        Http::fake([
            'iam-siasn.bkn.go.id/*' => Http::response(['error' => 'invalid_grant'], 401),
        ]);

        $service = app(SiasnSsoService::class);

        $this->assertNull($service->authenticate('199001012020011001', 'salah'));
    }

    public function test_login_tab_hidden_when_siasn_not_configured()
    {
        config(['services.siasn.sso.training.client_id' => null, 'services.siasn.mode' => 'training']);

        $response = $this->get('/login');

        $response->assertOk();
        $response->assertDontSee('/login/siasn');
    }

    public function test_login_tab_shown_when_siasn_configured()
    {
        config(['services.siasn.sso.training.client_id' => 'fake-client-id', 'services.siasn.mode' => 'training']);

        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('/login/siasn');
    }

    public function test_siasn_login_rejects_when_not_configured()
    {
        config(['services.siasn.sso.training.client_id' => null, 'services.siasn.mode' => 'training']);

        $response = $this->post('/login/siasn', ['nip' => '123', 'password' => 'x']);

        $response->assertSessionHas('loginerror');
        $this->assertGuest();
    }

    public function test_valid_siasn_identity_without_linked_local_account_is_rejected()
    {
        config([
            'services.siasn.mode' => 'training',
            'services.siasn.sso.training.client_id' => 'fake-client-id',
            'services.siasn.sso.training.url' => 'https://iam-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token',
        ]);

        $jwt = $this->fakeJwt(['preferred_username' => '199001012020011099']);
        Http::fake(['iam-siasn.bkn.go.id/*' => Http::response(['access_token' => $jwt], 200)]);

        $response = $this->post('/login/siasn', ['nip' => '199001012020011099', 'password' => 'benar']);

        $response->assertSessionHas('loginerror');
        $this->assertStringContainsString('belum terdaftar', session('loginerror'));
        $this->assertGuest();
    }

    public function test_valid_siasn_identity_with_linked_local_account_logs_in()
    {
        config([
            'services.siasn.mode' => 'training',
            'services.siasn.sso.training.client_id' => 'fake-client-id',
            'services.siasn.sso.training.url' => 'https://iam-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token',
        ]);

        $user = User::factory()->create(['nip' => '199001012020011001']);

        $jwt = $this->fakeJwt(['preferred_username' => '199001012020011001', 'name' => $user->name]);
        Http::fake(['iam-siasn.bkn.go.id/*' => Http::response(['access_token' => $jwt], 200)]);

        $response = $this->post('/login/siasn', ['nip' => '199001012020011001', 'password' => 'benar']);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
    }

    public function test_wrong_siasn_password_does_not_log_in()
    {
        config([
            'services.siasn.mode' => 'training',
            'services.siasn.sso.training.client_id' => 'fake-client-id',
            'services.siasn.sso.training.url' => 'https://iam-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token',
        ]);

        User::factory()->create(['nip' => '199001012020011001']);
        Http::fake(['iam-siasn.bkn.go.id/*' => Http::response(['error' => 'invalid_grant'], 401)]);

        $response = $this->post('/login/siasn', ['nip' => '199001012020011001', 'password' => 'salah']);

        $response->assertSessionHas('loginerror');
        $this->assertGuest();
    }

    public function test_siasn_login_still_honors_two_factor_when_enabled_on_linked_account()
    {
        config([
            'services.siasn.mode' => 'training',
            'services.siasn.sso.training.client_id' => 'fake-client-id',
            'services.siasn.sso.training.url' => 'https://iam-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token',
        ]);

        $user = User::factory()->create([
            'nip' => '199001012020011001',
            'two_factor_secret' => 'SECRETKEY123456',
            'two_factor_enabled_at' => now(),
        ]);

        $jwt = $this->fakeJwt(['preferred_username' => '199001012020011001']);
        Http::fake(['iam-siasn.bkn.go.id/*' => Http::response(['access_token' => $jwt], 200)]);

        $response = $this->post('/login/siasn', ['nip' => '199001012020011001', 'password' => 'benar']);

        $response->assertRedirect('/login/verifikasi-2fa');
        $this->assertGuest();
    }

    public function test_admin_can_link_nip_when_creating_user()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/register', [
            'name' => 'Admin Baru',
            'username' => 'adminbaru',
            'email' => 'adminbaru@example.com',
            'password' => 'password123',
            'nip' => '199001012020011002',
        ]);

        $response->assertRedirect('/admin/register');
        $this->assertDatabaseHas('users', ['email' => 'adminbaru@example.com', 'nip' => '199001012020011002']);
    }

    public function test_duplicate_nip_is_rejected_when_creating_user()
    {
        $admin = User::factory()->create();
        User::factory()->create(['nip' => '199001012020011003']);

        $response = $this->actingAs($admin)->post('/admin/register', [
            'name' => 'Admin Duplikat',
            'username' => 'adminduplikat',
            'email' => 'adminduplikat@example.com',
            'password' => 'password123',
            'nip' => '199001012020011003',
        ]);

        $response->assertSessionHasErrors('nip');
    }
}
