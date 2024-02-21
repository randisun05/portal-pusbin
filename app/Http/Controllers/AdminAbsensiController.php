<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;


class AdminAbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $absensis = Absensi::latest()->where('kegiatan_id','not like','1');

        if(request('search')){
            $absensis->where('kegiatan_id','like',request('search'));
        }
        return view('admin.absensi.index', [
            'kegiatans' => Kegiatan::all(),
            "absensis" => $absensis->get(),

        ]);

    }

    public function index1()
    {

        return view('absensi.select', [
            'kegiatans' => Kegiatan::all(),
            'title' => "Absensi"
        ]);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Kegiatan $kegiatan)
    {
        return view('absensi.create', [
            // 'kegiatans' => Kegiatan::get()->where('id','>','1'),
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
