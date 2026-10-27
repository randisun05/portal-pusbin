<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Kegiatan;
use Endroid\QrCode\QrCode;

trait GeneratesKegiatanQr
{
    /**
     * Buat data URI kode QR yang mengarah ke form absensi kegiatan yang
     * sudah ada (URL-nya sama persis dengan yang dipakai kalau peserta
     * masuk lewat daftar /absensi biasa) - QR ini cuma pintasan, bukan
     * mekanisme baru.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return string
     */
    protected function absensiQrCodeDataUri(Kegiatan $kegiatan): string
    {
        $url = url('/absensi/' . $kegiatan->slug);

        $qrCode = new QrCode($url);
        $qrCode->setSize(220);
        $qrCode->setMargin(8);

        return $qrCode->writeDataUri();
    }
}
