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

    protected function configureSiasn(?string $clientId = 'fake-client-id'): void
    {
        config([
            'services.siasn.mode' => 'training',
            'services.siasn.sso.training.client_id' => $clientId,
            'services.siasn.sso.training.url' => 'https://iam-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token',
        ]);
    }

    protected function startFlow(): string
    {
        $this->get('/login/sso/redirect')->assertRedirect();

        return session('siasn:state');
    }

    public function test_service_not_configured_without_client_id_and_cannot_exchange()
    {
        $this->configureSiasn(null);

        $service = app(SiasnSsoService::class);

        $this->assertFalse($service->isConfigured());
        $this->assertNull($service->exchangeCode('kode', 'verifier'));
    }

    public function test_authorization_url_uses_code_flow_with_pkce()
    {
        $this->configureSiasn();

        $auth = app(SiasnSsoService::class)->buildAuthorization();

        $this->assertStringStartsWith('https://iam-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/auth?', $auth['url']);
        $this->assertStringContainsString('response_type=code', $auth['url']);
        $this->assertStringContainsString('client_id=fake-client-id', $auth['url']);
        $this->assertStringContainsString('code_challenge_method=S256', $auth['url']);
        $this->assertStringContainsString('state=' . $auth['state'], $auth['url']);
    }

    public function test_exchange_code_posts_correct_grant_and_returns_claims()
    {
        $this->configureSiasn();

        $jwt = $this->fakeJwt(['preferred_username' => '199001012020011001', 'name' => 'Budi Santoso']);
        Http::fake(['iam-siasn.bkn.go.id/*' => Http::response(['access_token' => $jwt], 200)]);

        $result = app(SiasnSsoService::class)->exchangeCode('kode-abc', 'verifier-xyz');

        $this->assertSame('199001012020011001', $result['nip']);
        $this->assertSame('Budi Santoso', $result['name']);

        Http::assertSent(function ($request) {
            return $request['grant_type'] === 'authorization_code'
                && $request['client_id'] === 'fake-client-id'
                && $request['code'] === 'kode-abc'
                && $request['code_verifier'] === 'verifier-xyz';
        });
    }

    public function test_exchange_code_returns_null_when_bkn_rejects()
    {
        $this->configureSiasn();
        Http::fake(['iam-siasn.bkn.go.id/*' => Http::response(['error' => 'invalid_grant'], 400)]);

        $this->assertNull(app(SiasnSsoService::class)->exchangeCode('salah', 'verifier'));
    }

    public function test_sso_button_hidden_when_siasn_not_configured()
    {
        $this->configureSiasn(null);

        $this->get('/login/sso')->assertOk()->assertDontSee('/login/sso/redirect');
    }

    public function test_sso_button_shown_when_siasn_configured()
    {
        $this->configureSiasn();

        $this->get('/login/sso')->assertOk()->assertSee('/login/sso/redirect');
    }

    public function test_sso_redirect_rejects_when_not_configured()
    {
        $this->configureSiasn(null);

        $this->get('/login/sso/redirect')->assertRedirect('/login/sso')->assertSessionHas('loginerror');
        $this->assertGuest();
    }

    public function test_callback_with_wrong_state_is_rejected()
    {
        $this->configureSiasn();
        $this->startFlow();

        $this->get('/login/sso/callback?code=abc&state=salah')->assertSessionHas('loginerror');
        $this->assertGuest();
    }

    public function test_valid_siasn_identity_without_linked_local_account_is_rejected()
    {
        $this->configureSiasn();
        $state = $this->startFlow();

        $jwt = $this->fakeJwt(['preferred_username' => '199001012020011099']);
        Http::fake(['iam-siasn.bkn.go.id/*' => Http::response(['access_token' => $jwt], 200)]);

        $this->get('/login/sso/callback?code=abc&state=' . $state)->assertSessionHas('loginerror');
        $this->assertStringContainsString('belum terdaftar', session('loginerror'));
        $this->assertGuest();
    }

    public function test_valid_siasn_identity_with_linked_local_account_logs_in()
    {
        $this->configureSiasn();
        $user = User::factory()->create(['nip' => '199001012020011001']);
        $state = $this->startFlow();

        $jwt = $this->fakeJwt(['preferred_username' => '199001012020011001', 'name' => $user->name]);
        Http::fake(['iam-siasn.bkn.go.id/*' => Http::response(['access_token' => $jwt], 200)]);

        $this->get('/login/sso/callback?code=abc&state=' . $state)->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
    }

    public function test_rejected_code_exchange_does_not_log_in()
    {
        $this->configureSiasn();
        User::factory()->create(['nip' => '199001012020011001']);
        $state = $this->startFlow();

        Http::fake(['iam-siasn.bkn.go.id/*' => Http::response(['error' => 'invalid_grant'], 400)]);

        $this->get('/login/sso/callback?code=abc&state=' . $state)->assertSessionHas('loginerror');
        $this->assertGuest();
    }

    public function test_siasn_login_still_honors_two_factor_when_enabled_on_linked_account()
    {
        $this->configureSiasn();
        User::factory()->create([
            'nip' => '199001012020011001',
            'two_factor_secret' => 'SECRETKEY123456',
            'two_factor_enabled_at' => now(),
        ]);
        $state = $this->startFlow();

        $jwt = $this->fakeJwt(['preferred_username' => '199001012020011001']);
        Http::fake(['iam-siasn.bkn.go.id/*' => Http::response(['access_token' => $jwt], 200)]);

        $this->get('/login/sso/callback?code=abc&state=' . $state)->assertRedirect('/login/verifikasi-2fa');
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
