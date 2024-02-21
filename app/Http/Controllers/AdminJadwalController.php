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
            "jadwals" => JadwalUkom::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JadwalUkom  $jadwalUkom
     * @return \Illuminate\Http\Response
     */
    public function show(JadwalUkom $jadwalUkom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JadwalUkom  $jadwalUkom
     * @return \Illuminate\Http\Response
     */
    public function edit(JadwalUkom $jadwalUkom)
    {
        return $jadwalUkom;
        return view('admin.jadwalukom.edit',[
            'jadwal' => JadwalUkom::all(),
            'jadwal' => $jadwalUkom
           ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JadwalUkom  $jadwalUkom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JadwalUkom $jadwalUkom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JadwalUkom  $jadwalUkom
     * @return \Illuminate\Http\Response
     */
    public function destroy(JadwalUkom $jadwalUkom)
    {
        //
    }
}
