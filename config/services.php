<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'jf_management' => [
        'url' => env('JF_MANAGEMENT_API_URL'),
        'key' => env('JF_MANAGEMENT_API_KEY'),
    ],

    'anthropic' => [
        'api_key' => env('ANTHROPIC_API_KEY'),
    ],

    'gemini' => [
        // Satu key (cara lama). Tetap dipakai sebagai GEMINI_API_KEY_1 bila _1 kosong.
        'api_key' => env('GEMINI_API_KEY'),
        // Hingga 5 key dipakai bergantian: jika kuota key sebelumnya habis atau error
        // otomatis pindah ke key berikutnya (lihat App\Services\GeminiKeyPool).
        'keys' => [
            env('GEMINI_API_KEY_1') ?: env('GEMINI_API_KEY'),
            env('GEMINI_API_KEY_2'),
            env('GEMINI_API_KEY_3'),
            env('GEMINI_API_KEY_4'),
            env('GEMINI_API_KEY_5'),
        ],
        'model' => env('GEMINI_MODEL', 'gemini-2.0-flash'),
    ],

    'recaptcha' => [
        'site_key' => env('RECAPTCHA_SITE_KEY'),
        'secret_key' => env('RECAPTCHA_SECRET_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | SSO SIASN (BKN)
    |--------------------------------------------------------------------------
    |
    | Endpoint & struktur config di bawah ini disalin dari implementasi
    | Laravel nyata yang sudah dipakai untuk integrasi SIASN
    | (kanekescom/laravel-siasn-api), bukan dikira-kira - supaya kalau nanti
    | dibutuhkan integrasi SIASN lain (bukan cuma SSO), konvensi nama env
    | sudah konsisten. Login SSO SIASN otomatis nonaktif (tidak muncul di
    | halaman login) selama SIASN_SSO_CLIENT_ID kosong, karena client_id ini
    | harus didaftarkan resmi ke tim integrasi SIASN BKN - tidak bisa diisi
    | sembarangan.
    |
    */
    'siasn' => [
        'mode' => env('SIASN_MODE', 'training'),

        'sso' => [
            'production' => [
                'url' => env('SIASN_SSO_URL', 'https://sso-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token'),
                'client_id' => env('SIASN_SSO_CLIENT_ID'),
            ],
            'training' => [
                'url' => env('SIASN_SSO_URL_TRAINING', 'https://iam-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token'),
                'client_id' => env('SIASN_SSO_CLIENT_ID_TRAINING', env('SIASN_SSO_CLIENT_ID')),
            ],

            // Callback login MyASN. Kosongkan untuk memakai {APP_URL}/login/sso/callback.
            // Alamat ini harus terdaftar sebagai valid redirect URI untuk client_id di SSO SIASN.
            'redirect_uri' => env('SIASN_SSO_REDIRECT_URI'),
        ],
    ],

];
