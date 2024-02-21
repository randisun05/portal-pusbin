<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KodeKonsultasi;
use Illuminate\Http\Request;

class KodeKonsultasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.kodekonsultasi.index', [
            "kodes" => KodeKonsultasi::all(),
            'title' => "Kode Konsultasi",

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.kodekonsultasi.create', [
            "kodes" => KodeKonsultasi::all(),
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

        KodeKonsultasi::create($validatedData);

        return redirect()->to('/admin/kodekonsultasi')->with('success', 'Kode Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(KodeKonsultasi $kode)
    {
        return view('admin.kodekonsultasi.edit',[
            'kode' =>  $kode
       ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KodeKonsultasi $kodes)
    {

        $validateData = $request->validate([
            "*" => 'required',

        ]);

        KodeKonsultasi::where('id', $kodes->id)
                ->update($validateData);

        return redirect('/admin/kodekonsultasi')->with('success','Kode Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        KodeKonsultasi::destroy($id);
        return redirect('/admin/kodekonsultasi')->with('success','Kode Berhasil Dihapus');
    }
}
