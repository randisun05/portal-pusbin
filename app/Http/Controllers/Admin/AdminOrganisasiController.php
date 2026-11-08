<?php

namespace App\Http\Controllers\Admin;

use App\Models\OrganisasiUnit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdminOrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.organisasi.index', [
            'units' => OrganisasiUnit::with('parent')->orderBy('urutan')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.organisasi.create', [
            'title' => 'Struktur Organisasi',
            'parents' => OrganisasiUnit::orderBy('urutan')->get(),
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
            'nama' => 'required',
            'jabatan' => 'required',
            'unit' => 'nullable',
            'deskripsi' => 'nullable',
            'urutan' => 'nullable|integer',
            'parent_id' => 'nullable|exists:organisasi_units,id',
            'foto' => 'nullable|image|file|max:1024',
        ]);

        if ($request->file('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('organisasi-image');
        }

        OrganisasiUnit::create($validatedData);

        return redirect()->to('/admin/organisasi')->with('success', 'Struktur Organisasi Berhasil Dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        {

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrganisasiUnit  $organisasi
     * @return \Illuminate\Http\Response
     */
    public function edit(OrganisasiUnit $organisasi)
    {
        return view('admin.organisasi.edit', [
            'title' => 'Struktur Organisasi',
            'unit' => $organisasi,
            'parents' => OrganisasiUnit::where('id', '!=', $organisasi->id)->orderBy('urutan')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrganisasiUnit  $organisasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrganisasiUnit $organisasi)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'unit' => 'nullable',
            'deskripsi' => 'nullable',
            'urutan' => 'nullable|integer',
            'parent_id' => 'nullable|exists:organisasi_units,id',
            'foto' => 'nullable|image|file|max:1024',
        ]);

        if ($validatedData['parent_id'] == $organisasi->id) {
            return back()->withErrors(['parent_id' => 'Atasan tidak boleh diri sendiri'])->withInput();
        }

        if ($request->file('foto')) {
            if ($request->oldFoto) {
                Storage::delete($request->oldFoto);
            }
            $validatedData['foto'] = $request->file('foto')->store('organisasi-image');
        }

        $organisasi->update($validatedData);

        return redirect('/admin/organisasi')->with('success', 'Struktur Organisasi Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrganisasiUnit  $organisasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrganisasiUnit $organisasi)
    {
        if ($organisasi->foto) {
            Storage::delete($organisasi->foto);
        }
        $organisasi->delete();

        return redirect('/admin/organisasi')->with('success', 'Struktur Organisasi Berhasil Dihapus');
    }
}
