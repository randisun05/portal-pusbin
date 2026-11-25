<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait GuardsAgainstSpam
{
    /**
     * Anggap submission sebagai spam jika honeypot terisi (bot mengisi field
     * tersembunyi), atau jika reCAPTCHA dikonfigurasi tapi verifikasinya gagal.
     */
    protected function isSpamSubmission(Request $request): bool
    {
        if (filled($request->input('website'))) {
            return true;
        }

        return $this->failsRecaptcha($request);
    }

    /**
     * Verifikasi reCAPTCHA v2 ke Google. Mengembalikan false (tidak spam)
     * jika reCAPTCHA belum dikonfigurasi (RECAPTCHA_SECRET_KEY kosong), atau
     * jika verifikasi ke Google gagal dihubungi (fail-open supaya gangguan
     * di sisi Google tidak memblokir pengunjung asli). Mengembalikan true
     * (dianggap spam) jika reCAPTCHA aktif tapi token tidak ada atau Google
     * secara eksplisit menolaknya.
     */
    protected function failsRecaptcha(Request $request): bool
    {
        $secret = config('services.recaptcha.secret_key');

        if (empty($secret)) {
            return false;
        }

        $token = $request->input('g-recaptcha-response');

        if (empty($token)) {
            return true;
        }

        try {
            $response = Http::asForm()->timeout(10)->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secret,
                'response' => $token,
                'remoteip' => $request->ip(),
            ]);

            return ! ($response->successful() && $response->json('success') === true);
        } catch (\Throwable $e) {
            Log::warning('GuardsAgainstSpam: gagal menghubungi reCAPTCHA API.', ['error' => $e->getMessage()]);

            return false;
        }
    }
}
