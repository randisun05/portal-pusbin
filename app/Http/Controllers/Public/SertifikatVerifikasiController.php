<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use Illuminate\Http\Request;

class SertifikatVerifikasiController extends Controller
{
    /**
     * Tampilkan form verifikasi & hasil pencarian sertifikat berdasarkan nomor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sertifikat = null;
        $notFound = false;

        if ($request->filled('nomor')) {
            $sertifikat = Sertifikat::with('absensi.kegiatan')
                ->where('nomor_sertifikat', $request->nomor)
                ->first();

            $notFound = ! $sertifikat;
        }

        return view('public.sertifikat.verifikasi', [
            'title' => 'Verifikasi Sertifikat',
            'nomor' => $request->nomor,
            'sertifikat' => $sertifikat,
            'notFound' => $notFound,
        ]);
    }
}
