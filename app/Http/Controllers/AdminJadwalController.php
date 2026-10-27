<?php

namespace App\Http\Controllers;

use App\Models\JadwalUkom;
use Illuminate\Http\Request;

class AdminJadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.jadwalukom.index', [
            "jadwals" => JadwalUkom::orderBy('periode')->get()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(JadwalUkom $jadwalukom)
    {
        return redirect("/admin/jadwalukom/{$jadwalukom->id}/edit");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.jadwalukom.create');
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
            'periode' => 'required|string|max:255',
            'bulan' => 'required|string|max:255',
            'batasdaftar' => 'required|string|max:255',
        ]);

        JadwalUkom::create($validatedData);

        return redirect('/admin/jadwalukom')->with('success', 'Jadwal Ujikom berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(JadwalUkom $jadwalukom)
    {
        return view('admin.jadwalukom.edit', [
            'jadwal' => $jadwalukom,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JadwalUkom $jadwalukom)
    {
        $validatedData = $request->validate([
            'periode' => 'required|string|max:255',
            'bulan' => 'required|string|max:255',
            'batasdaftar' => 'required|string|max:255',
        ]);

        $jadwalukom->update($validatedData);

        return redirect('/admin/jadwalukom')->with('success', 'Jadwal Ujikom berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(JadwalUkom $jadwalukom)
    {
        $jadwalukom->delete();

        return redirect('/admin/jadwalukom')->with('success', 'Jadwal Ujikom berhasil dihapus');
    }
}
