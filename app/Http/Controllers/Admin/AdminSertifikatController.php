<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kegiatan;
use App\Models\Absensi;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use App\Services\JfManagementService;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\QrCode;

class AdminSertifikatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kegiatans = Kegiatan::orderByDesc('waktu')->get();

        $absensis = collect();
        if ($request->kegiatan_id) {
            $absensis = Absensi::where('kegiatan_id', $request->kegiatan_id)
                ->with(['kegiatan', 'sertifikat'])
                ->latest()
                ->get();
        }

        return view('admin.sertifikat.index', [
            'title' => 'Sertifikat Kegiatan',
            'kegiatans' => $kegiatans,
            'absensis' => $absensis,
            'kegiatanId' => $request->kegiatan_id,
            'jfConfigured' => ! empty(config('services.jf_management.url')),
        ]);
    }

    /**
     * Terbitkan sertifikat untuk satu data absensi.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function issue(Absensi $absensi)
    {
        if ($absensi->sertifikat) {
            return back()->with('error', 'Sertifikat untuk peserta ini sudah diterbitkan.');
        }

        Sertifikat::create([
            'absensi_id' => $absensi->id,
            'nomor_sertifikat' => Sertifikat::generateNomor(),
        ]);

        return back()->with('success', 'Sertifikat berhasil diterbitkan.');
    }

    /**
     * Kirim data sertifikat ke sistem Manajemen JF.
     *
     * @param  \App\Models\Sertifikat  $sertifikat
     * @param  \App\Services\JfManagementService  $service
     * @return \Illuminate\Http\Response
     */
    public function send(Sertifikat $sertifikat, JfManagementService $service)
    {
        $sertifikat = $service->send($sertifikat);

        if ($sertifikat->status === 'terkirim') {
            return back()->with('success', 'Data sertifikat berhasil dikirim ke Manajemen JF.');
        }

        return back()->with('error', 'Data belum terkirim: ' . $sertifikat->sent_response);
    }

    /**
     * Tampilkan sertifikat untuk dicetak.
     *
     * @param  \App\Models\Sertifikat  $sertifikat
     * @return \Illuminate\Http\Response
     */
    public function cetak(Sertifikat $sertifikat)
    {
        return view('admin.sertifikat.cetak', [
            'sertifikat' => $sertifikat->load('absensi.kegiatan'),
            'qrCode' => $this->qrCodeDataUri($sertifikat),
        ]);
    }

    /**
     * Unduh sertifikat sebagai file PDF.
     *
     * @param  \App\Models\Sertifikat  $sertifikat
     * @return \Illuminate\Http\Response
     */
    public function download(Sertifikat $sertifikat)
    {
        $sertifikat->load('absensi.kegiatan');

        $pdf = Pdf::loadView('admin.sertifikat.pdf', [
            'sertifikat' => $sertifikat,
            'qrCode' => $this->qrCodeDataUri($sertifikat),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Sertifikat-' . str_replace('/', '-', $sertifikat->nomor_sertifikat) . '.pdf');
    }

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
