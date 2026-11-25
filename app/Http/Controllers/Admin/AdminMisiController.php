<?php

namespace App\Http\Controllers\Admin;

use App\Models\MisiItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminMisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.misi.index', [
            'items' => MisiItem::orderBy('urutan')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.misi.create', [
            'title' => 'Misi',
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
            'isi' => 'required',
            'urutan' => 'nullable|integer',
        ]);

        MisiItem::create($validatedData);

        return redirect('/admin/misi')->with('success', 'Misi Berhasil Dibuat');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MisiItem  $misi
     * @return \Illuminate\Http\Response
     */
    public function edit(MisiItem $misi)
    {
        return view('admin.misi.edit', [
            'title' => 'Misi',
            'item' => $misi,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MisiItem  $misi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MisiItem $misi)
    {
        $validatedData = $request->validate([
            'isi' => 'required',
            'urutan' => 'nullable|integer',
        ]);

        $misi->update($validatedData);

        return redirect('/admin/misi')->with('success', 'Misi Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MisiItem  $misi
     * @return \Illuminate\Http\Response
     */
    public function destroy(MisiItem $misi)
    {
        $misi->delete();

        return redirect('/admin/misi')->with('success', 'Misi Berhasil Dihapus');
    }
}
