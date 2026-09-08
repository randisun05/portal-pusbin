<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kegiatan;
use App\Models\Absensi;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use App\Services\JfManagementService;
use App\Http\Controllers\Controller;

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
        ]);
    }
}
