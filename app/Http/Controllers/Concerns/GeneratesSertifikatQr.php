<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Sertifikat;
use Endroid\QrCode\QrCode;

trait GeneratesSertifikatQr
{
    /**
     * Buat data URI kode QR yang mengarah ke halaman verifikasi sertifikat.
     *
     * @param  \App\Models\Sertifikat  $sertifikat
     * @return string
     */
    protected function qrCodeDataUri(Sertifikat $sertifikat): string
    {
        $url = url('/verifikasi-sertifikat') . '?nomor=' . urlencode($sertifikat->nomor_sertifikat);

        $qrCode = new QrCode($url);
        $qrCode->setSize(180);
        $qrCode->setMargin(6);

        return $qrCode->writeDataUri();
    }
}
