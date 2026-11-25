<?php

if (! function_exists('mask_nip')) {
    /** Samarkan NIP untuk tampilan publik: 6 digit awal dan 4 digit akhir saja. */
    function mask_nip(?string $nip): string
    {
        $nip = (string) $nip;

        return strlen($nip) > 10 ? \Illuminate\Support\Str::mask($nip, '*', 6, strlen($nip) - 10) : $nip;
    }
}
