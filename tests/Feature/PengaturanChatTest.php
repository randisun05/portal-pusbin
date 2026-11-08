<?php

namespace Tests\Feature;

use App\Models\PengaturanChat;
use App\Models\Pengetahuan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PengaturanChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_default_provider_is_claude()
    {
        $this->assertSame(PengaturanChat::PROVIDER_CLAUDE, PengaturanChat::current()->provider);
    }

    public function test_admin_can_switch_provider_to_gemini()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->put('/admin/pengaturan-chat', [
            'provider' => 'gemini',
        ]);

        $response->assertRedirect('/admin/pengaturan-chat');
        $this->assertSame('gemini', PengaturanChat::current()->fresh()->provider);
    }

    public function test_invalid_provider_is_rejected()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->put('/admin/pengaturan-chat', [
            'provider' => 'chatgpt',
        ]);

        $response->assertSessionHasErrors('provider');
    }

    public function test_guest_cannot_access_pengaturan_chat()
    {
        $response = $this->get('/admin/pengaturan-chat');

        $response->assertRedirect('/login');
    }

    public function test_role_without_permission_is_denied()
    {
        $role = Role::create(['name' => 'editor-terbatas-chat-ai', 'label' => 'Editor Terbatas']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($user)->get('/admin/pengaturan-chat');

        $response->assertForbidden();
    }

    public function test_chat_ask_uses_claude_service_when_provider_is_claude_and_returns_null_without_key()
    {
        PengaturanChat::current()->update(['provider' => 'claude']);

        $response = $this->postJson('/chat/ask', ['question' => 'Halo?']);

        $response->assertOk();
        $response->assertJson(['answer' => null]);
    }

    public function test_chat_ask_uses_gemini_service_when_provider_is_gemini_and_returns_null_without_key()
    {
        PengaturanChat::current()->update(['provider' => 'gemini']);

        $response = $this->postJson('/chat/ask', ['question' => 'Halo?']);

        $response->assertOk();
        $response->assertJson(['answer' => null]);
    }

    public function test_gemini_service_calls_correct_endpoint_and_parses_response()
    {
        config(['services.gemini.api_key' => 'fake-test-key']);
        PengaturanChat::current()->update(['provider' => 'gemini']);
        Pengetahuan::create(['judul' => 'Materi X', 'isi' => 'Isi materi X.', 'aktif' => true]);

        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    ['content' => ['parts' => [['text' => 'Jawaban dari Gemini.']]]],
                ],
            ], 200),
        ]);

        $response = $this->postJson('/chat/ask', ['question' => 'Apa itu materi X?']);

        $response->assertOk();
        $response->assertJson(['answer' => 'Jawaban dari Gemini.']);

        Http::assertSent(function ($request) {
            return str_contains($request->url(), 'generativelanguage.googleapis.com')
                && str_contains($request->url(), 'gemini-2.0-flash')
                && $request['contents'][0]['parts'][0]['text'] === 'Apa itu materi X?'
                && str_contains($request['systemInstruction']['parts'][0]['text'], 'Materi X');
        });
    }

    public function test_gemini_service_returns_null_on_api_error()
    {
        config(['services.gemini.api_key' => 'fake-test-key']);
        PengaturanChat::current()->update(['provider' => 'gemini']);

        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response(['error' => ['message' => 'invalid key']], 400),
        ]);

        $response = $this->postJson('/chat/ask', ['question' => 'Halo?']);

        $response->assertOk();
        $response->assertJson(['answer' => null]);
    }
}
