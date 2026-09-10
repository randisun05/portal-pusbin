<?php

namespace App\Http\Controllers;

use App\Exports\AbsensiExport;
use App\Models\Absensi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;


class AdminAbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $absensis = Absensi::latest();
        $ids = Kegiatan::where('jenis','Konsultasi')->pluck('id');

        if(request('search')){
            $absensis->where('kegiatan_id','like',request('search'));
        }

        // Menambahkan kondisi whereNotIn setelah penanganan pencarian
        $absensis->whereNotIn('kegiatan_id', $ids);
        $absensis = $absensis->paginate(10);

        return view('admin.absensi.index', [
            'kegiatans' => Kegiatan::where('jenis','!=', 'Konsultasi')->get(),
            "absensis" => $absensis
        ]);

    }


    /**
     * Ekspor data absensi (mengikuti filter kegiatan yang sedang aktif) ke Excel.
     *
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        $nama = request('search') ? optional(Kegiatan::find(request('search')))->nama : 'Semua-Kegiatan';
        $filename = 'Absensi-' . str_replace(' ', '-', $nama) . '-' . now()->format('Ymd-His') . '.xlsx';

        return Excel::download(new AbsensiExport(request('search')), $filename);
    }

    /**
     * Cetak daftar hadir (PDF) untuk kegiatan yang sedang difilter.
     *
     * @return \Illuminate\Http\Response
     */
    public function cetakDaftarHadir()
    {
        $kegiatan = request('search') ? Kegiatan::find(request('search')) : null;

        $absensis = Absensi::with('kegiatan')->latest();
        $ids = Kegiatan::where('jenis', 'Konsultasi')->pluck('id');
        $absensis->whereNotIn('kegiatan_id', $ids);

        if (request('search')) {
            $absensis->where('kegiatan_id', request('search'));
        }

        $pdf = Pdf::loadView('admin.absensi.daftar-hadir', [
            'kegiatan' => $kegiatan,
            'absensis' => $absensis->get(),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('Daftar-Hadir-' . now()->format('Ymd-His') . '.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Kegiatan $kegiatan)
    {
        return view('public.absensi.create', [

            'title' => "Absensi Kegiatan {$kegiatan->nama}",
            'kegiatan' => $kegiatan,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "*" => 'required',
        ]);

        Absensi::create($validatedData);

        return redirect()->to('/absensi')->with('success', 'Berhasil Melakukan Absensi');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function show(Absensi $absensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function edit(Absensi $absensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Absensi $absensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absensi $absensi)
    {
        //
    }
}
