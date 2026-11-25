<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SiasnSsoService
{
    /**
     * Susun URL otorisasi SSO SIASN (Keycloak BKN) untuk alur authorization
     * code + PKCE. Pengguna diarahkan ke halaman login MyASN, lalu kembali ke
     * redirect_uri dengan parameter "code". "state" dan "code_verifier"
     * dibuat acak per permintaan dan harus disimpan (session) oleh pemanggil
     * untuk dicocokkan di callback.
     *
     * @return array{url: string, state: string, verifier: string}
     */
    public function buildAuthorization(): array
    {
        $config = $this->activeConfig();

        $state = Str::random(32);
        $verifier = $this->base64Url(random_bytes(48));
        $challenge = $this->base64Url(hash('sha256', $verifier, true));

        $query = http_build_query([
            'client_id' => $config['client_id'],
            'redirect_uri' => $this->redirectUri(),
            'response_type' => 'code',
            'response_mode' => 'query',
            'scope' => 'openid',
            'state' => $state,
            'code_challenge' => $challenge,
            'code_challenge_method' => 'S256',
        ], '', '&', PHP_QUERY_RFC3986);

        return [
            'url' => $this->authorizationEndpoint() . '?' . $query,
            'state' => $state,
            'verifier' => $verifier,
        ];
    }

    /**
     * Tukar authorization code dengan token ke SSO SIASN, lalu kembalikan
     * klaim identitas. Null jika gagal / belum dikonfigurasi.
     *
     * @return array{nip: ?string, name: ?string, raw: array}|null
     */
    public function exchangeCode(string $code, string $verifier): ?array
    {
        $config = $this->activeConfig();

        if (empty($config['client_id'])) {
            return null;
        }

        try {
            $response = Http::asForm()->timeout(15)->post($config['url'], [
                'grant_type' => 'authorization_code',
                'client_id' => $config['client_id'],
                'code' => $code,
                'redirect_uri' => $this->redirectUri(),
                'code_verifier' => $verifier,
            ]);

            if (! $response->successful()) {
                Log::info('SiasnSsoService: SSO SIASN menolak penukaran code.', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);

                return null;
            }

            $token = $response->json('id_token') ?: $response->json('access_token');

            if (empty($token)) {
                return null;
            }

            $claims = $this->decodeJwtClaims($token);

            if (empty($claims['preferred_username'])) {
                $claims = $this->decodeJwtClaims((string) $response->json('access_token')) + $claims;
            }

            if (empty($claims['preferred_username'])) {
                return null;
            }

            return [
                'nip' => $claims['preferred_username'],
                'name' => $claims['name'] ?? null,
                'raw' => $claims,
            ];
        } catch (\Throwable $e) {
            Log::warning('SiasnSsoService: gagal menghubungi SSO SIASN.', ['error' => $e->getMessage()]);

            return null;
        }
    }

    public function isConfigured(): bool
    {
        return ! empty($this->activeConfig()['client_id']);
    }

    /**
     * Alamat callback yang harus didaftarkan (sebagai valid redirect URI)
     * untuk client_id portal ini di SSO SIASN.
     */
    public function redirectUri(): string
    {
        return config('services.siasn.sso.redirect_uri') ?: url('/login/sso/callback');
    }

    protected function authorizationEndpoint(): string
    {
        return preg_replace('#/token$#', '/auth', $this->activeConfig()['url']);
    }

    /**
     * @return array{url: string, client_id: ?string}
     */
    protected function activeConfig(): array
    {
        $mode = config('services.siasn.mode', 'training') === 'production' ? 'production' : 'training';

        return config("services.siasn.sso.{$mode}");
    }

    protected function base64Url(string $binary): string
    {
        return rtrim(strtr(base64_encode($binary), '+/', '-_'), '=');
    }

    /**
     * Decode payload JWT tanpa verifikasi signature. Aman dilakukan di sini
     * karena token ini diperoleh langsung dari server BKN lewat panggilan
     * server-to-server HTTPS (bukan token yang dikirim klien), sekadar untuk
     * membaca klaim identitas (preferred_username, name, dst), bukan untuk
     * memutuskan otorisasi tanpa pengecekan lain.
     */
    protected function decodeJwtClaims(string $jwt): array
    {
        $segments = explode('.', $jwt);

        if (count($segments) !== 3) {
            return [];
        }

        $base64 = strtr($segments[1], '-_', '+/');
        $base64 .= str_repeat('=', (4 - strlen($base64) % 4) % 4);

        $payload = base64_decode($base64, true);
        $claims = $payload ? json_decode($payload, true) : null;

        return is_array($claims) ? $claims : [];
    }
}
