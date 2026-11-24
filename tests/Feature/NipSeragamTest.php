<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NipSeragamTest extends TestCase
{
    use RefreshDatabase;

    /** @dataProvider rute */
    public function test_nip_bukan_18_digit_ditolak_di_semua_form_publik(string $url): void
    {
        foreach (['123', 'abcdefghijklmnopqr', '1990010120200110011'] as $nip) {
            $this->post($url, ['nip' => $nip])->assertSessionHasErrors('nip');
        }
    }

    public static function rute(): array
    {
        return [['/sertifikat/unduh'], ['/konsultasi/usul']];
    }
}
