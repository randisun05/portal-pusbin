<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * Akses API BKN (apimws) untuk profil SIASN. Dua token dipakai bersamaan, sama seperti project ujikom-pusbin:
 * header Authorization: Bearer <client_credentials> dan header Auth: bearer <token SSO SIASN>.
 */
class SiasnApiService
{
    private const PROD = 'siasn.prod_token';
    private const AUTH = 'siasn.auth_token';

    public function prodToken(): string
    {
        if (($c = Cache::get(self::PROD)) && is_string($c)) {
            return $c;
        }

        $id = (string) config('services.bkn.client_id');
        $secret = (string) config('services.bkn.client_secret');
        if ($id === '' || $secret === '') {
            throw new \RuntimeException('BKN_CLIENT_ID / BKN_CLIENT_SECRET belum diisi di .env');
        }

        $r = Http::withBasicAuth($id, $secret)->asForm()->timeout(20)
            ->post('https://apimws.bkn.go.id/oauth2/token', ['grant_type' => 'client_credentials'])->throw();
        Cache::put(self::PROD, $r->json('access_token'), $this->ttl($r->json('expires_in')));

        return $r->json('access_token');
    }

    public function authToken(): string
    {
        $static = trim((string) config('services.bkn.siasn_token'));
        if ($static !== '') {
            return preg_replace('/^bearer\s+/i', '', $static);
        }
        if (($c = Cache::get(self::AUTH)) && is_string($c)) {
            return $c;
        }

        $r = Http::asForm()->timeout(20)->post(
            'https://sso-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token',
            [
                'client_id' => config('services.bkn.siasn_client_id'),
                'grant_type' => 'password',
                'username' => config('services.bkn.siasn_username'),
                'password' => config('services.bkn.siasn_password'),
            ]
        )->throw();
        Cache::put(self::AUTH, $r->json('access_token'), $this->ttl($r->json('expires_in')));

        return $r->json('access_token');
    }

    public function forgetTokens(): void
    {
        Cache::forget(self::PROD);
        Cache::forget(self::AUTH);
    }

    /** Id orang SIASN (diperlukan MyASN) untuk sebuah NIP; null bila tidak ditemukan. */
    public function orangId(string $nip): ?string
    {
        $url = rtrim((string) config('services.bkn.base_url'), '/') . '/pns/data-utama/' . rawurlencode($nip);
        $call = fn () => Http::acceptJson()->timeout(30)->withHeaders([
            'Authorization' => 'Bearer ' . $this->prodToken(),
            'Auth' => 'bearer ' . $this->authToken(),
        ])->get($url);

        $r = $call();
        if ($r->status() === 401) {
            $this->forgetTokens();
            $r = $call();
        }

        return $r->successful() ? ($r->json('data.id') ?: null) : null;
    }

    private function ttl($expiresIn): int
    {
        return max(60, (int) $expiresIn - 60);
    }
}
