<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pengetahuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPengetahuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pengetahuan.index', [
            'items' => Pengetahuan::orderBy('urutan')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pengetahuan.create', [
            'title' => 'Basis Pengetahuan',
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
            'judul' => 'required',
            'isi' => 'required',
            'kategori' => 'nullable',
            'kata_kunci' => 'nullable',
            'aktif' => 'nullable|boolean',
            'urutan' => 'nullable|integer',
        ]);

        $validatedData['aktif'] = $request->boolean('aktif');

        Pengetahuan::create($validatedData);

        return redirect('/admin/pengetahuan')->with('success', 'Materi Pengetahuan Berhasil Ditambah');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengetahuan  $pengetahuan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengetahuan $pengetahuan)
    {
        return view('admin.pengetahuan.edit', [
            'title' => 'Basis Pengetahuan',
            'item' => $pengetahuan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengetahuan  $pengetahuan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengetahuan $pengetahuan)
    {
        $validatedData = $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'kategori' => 'nullable',
            'kata_kunci' => 'nullable',
            'aktif' => 'nullable|boolean',
            'urutan' => 'nullable|integer',
        ]);

        $validatedData['aktif'] = $request->boolean('aktif');

        $pengetahuan->update($validatedData);

        return redirect('/admin/pengetahuan')->with('success', 'Materi Pengetahuan Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengetahuan  $pengetahuan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengetahuan $pengetahuan)
    {
        $pengetahuan->delete();

        return redirect('/admin/pengetahuan')->with('success', 'Materi Pengetahuan Berhasil Dihapus');
    }
}
