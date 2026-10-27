<?php

namespace App\Services;

use App\Models\User;
use Endroid\QrCode\QrCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorAuthService
{
    protected Google2FA $engine;

    public function __construct()
    {
        $this->engine = new Google2FA();
    }

    /**
     * Buat secret TOTP baru (belum disimpan, dipakai untuk tahap konfirmasi
     * sebelum 2FA benar-benar diaktifkan).
     */
    public function generateSecretKey(): string
    {
        return $this->engine->generateSecretKey();
    }

    /**
     * Buat data URI kode QR yang bisa dipindai aplikasi authenticator
     * (Google Authenticator, Authy, dsb).
     */
    public function qrCodeDataUri(User $user, string $secret): string
    {
        $url = $this->engine->getQRCodeUrl(
            config('app.name', 'Direktorat JF MASN'),
            $user->email,
            $secret
        );

        $qrCode = new QrCode($url);
        $qrCode->setSize(200);
        $qrCode->setMargin(6);

        return $qrCode->writeDataUri();
    }

    /**
     * Verifikasi kode 6 digit dari aplikasi authenticator terhadap secret.
     */
    public function verifyCode(string $secret, string $code): bool
    {
        return $this->engine->verifyKey($secret, str_replace(' ', '', $code));
    }

    /**
     * Buat sekumpulan recovery code sekali pakai. Nilai asli hanya
     * ditampilkan sekali ke admin saat dibuat; yang disimpan di database
     * adalah bentuk hash-nya saja.
     *
     * @return array{plain: array<int, string>, hashed: array<int, string>}
     */
    public function generateRecoveryCodes(int $count = 8): array
    {
        $plain = [];

        for ($i = 0; $i < $count; $i++) {
            $plain[] = Str::upper(Str::random(4) . '-' . Str::random(4));
        }

        return [
            'plain' => $plain,
            'hashed' => array_map(fn ($code) => Hash::make($code), $plain),
        ];
    }

    /**
     * Cek apakah kode recovery cocok dengan salah satu hash yang tersimpan.
     * Mengembalikan index yang cocok (untuk dihapus setelah dipakai), atau
     * null jika tidak ada yang cocok.
     */
    public function matchRecoveryCode(array $hashedCodes, string $inputCode): ?int
    {
        $inputCode = Str::upper(trim($inputCode));

        foreach ($hashedCodes as $index => $hashed) {
            if (Hash::check($inputCode, $hashed)) {
                return $index;
            }
        }

        return null;
    }
}
