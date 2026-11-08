<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\GeneratesSertifikatQr;
use App\Http\Controllers\Concerns\GuardsAgainstSpam;
use App\Models\Absensi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SertifikatUnduhController extends Controller
{
    use GuardsAgainstSpam, GeneratesSertifikatQr;

    /**
     * Tampilkan form pencarian sertifikat berdasarkan NIP & kegiatan.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('public.sertifikat.unduh', [
            'title' => 'Unduh Sertifikat',
            'kegiatans' => Kegiatan::where('jenis', '!=', 'Konsultasi')->orderByDesc('waktu')->get(),
        ]);
    }

    /**
     * Cari sertifikat milik peserta berdasarkan NIP & kegiatan, lalu unduh
     * langsung sebagai PDF apabila sudah diterbitkan oleh panitia.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function unduh(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required',
            'kegiatan_id' => 'required|exists:kegiatans,id',
        ]);

        if ($this->isSpamSubmission($request)) {
            return back()->withInput()->with('error', 'NIP tidak ditemukan pada kegiatan tersebut. Pastikan Anda sudah mengisi absensi.');
        }

        $absensi = Absensi::where('nip', $validated['nip'])
            ->where('kegiatan_id', $validated['kegiatan_id'])
            ->with('sertifikat')
            ->first();

        if (! $absensi) {
            return back()->withInput()->with('error', 'NIP tidak ditemukan pada kegiatan tersebut. Pastikan Anda sudah mengisi absensi.');
        }

        if (! $absensi->sertifikat) {
            return back()->withInput()->with('error', 'Sertifikat Anda belum diterbitkan oleh panitia. Silakan coba lagi beberapa saat lagi.');
        }

        $sertifikat = $absensi->sertifikat->load('absensi.kegiatan', 'template');

        $pdf = Pdf::loadView('admin.sertifikat.pdf', [
            'sertifikat' => $sertifikat,
            'qrCode' => $this->qrCodeDataUri($sertifikat),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Sertifikat-' . str_replace('/', '-', $sertifikat->nomor_sertifikat) . '.pdf');
    }
}
