<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;

trait GuardsAgainstSpam
{
    /**
     * Honeypot sederhana: field tersembunyi yang tidak pernah diisi pengunjung
     * asli, tapi sering otomatis diisi oleh bot. Jika terisi, permintaan
     * dianggap spam.
     */
    protected function isSpamSubmission(Request $request): bool
    {
        return filled($request->input('website'));
    }
}
