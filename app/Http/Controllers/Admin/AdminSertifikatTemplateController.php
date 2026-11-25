<?php

namespace App\Http\Controllers\Admin;

use App\Models\SertifikatTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AdminSertifikatTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.sertifikat-template.index', [
            'title' => 'Template Sertifikat',
            'templates' => SertifikatTemplate::orderByDesc('is_default')->orderBy('nama')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sertifikat-template.create', [
            'title' => 'Template Sertifikat',
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
            'warna_aksen' => 'required',
            'teks_pembuka' => 'required',
            'teks_keterangan' => 'required',
            'nama_penandatangan' => 'nullable',
            'jabatan_penandatangan' => 'nullable',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tanda_tangan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_default' => 'nullable|boolean',
        ]);

        if ($request->file('logo')) {
            $validatedData['logo'] = $request->file('logo')->store('sertifikat-template');
        }

        if ($request->file('tanda_tangan')) {
            $validatedData['tanda_tangan'] = $request->file('tanda_tangan')->store('sertifikat-template');
        }

        $validatedData['is_default'] = $request->boolean('is_default');

        if ($validatedData['is_default']) {
            SertifikatTemplate::query()->update(['is_default' => false]);
        }

        SertifikatTemplate::create($validatedData);

        return redirect('/admin/sertifikat-template')->with('success', 'Template Sertifikat Berhasil Dibuat');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SertifikatTemplate  $sertifikatTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(SertifikatTemplate $sertifikatTemplate)
    {
        return view('admin.sertifikat-template.edit', [
            'title' => 'Template Sertifikat',
            'template' => $sertifikatTemplate,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SertifikatTemplate  $sertifikatTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SertifikatTemplate $sertifikatTemplate)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'warna_aksen' => 'required',
            'teks_pembuka' => 'required',
            'teks_keterangan' => 'required',
            'nama_penandatangan' => 'nullable',
            'jabatan_penandatangan' => 'nullable',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tanda_tangan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_default' => 'nullable|boolean',
        ]);

        if ($request->file('logo')) {
            if ($sertifikatTemplate->logo) {
                Storage::delete($sertifikatTemplate->logo);
            }
            $validatedData['logo'] = $request->file('logo')->store('sertifikat-template');
        }

        if ($request->file('tanda_tangan')) {
            if ($sertifikatTemplate->tanda_tangan) {
                Storage::delete($sertifikatTemplate->tanda_tangan);
            }
            $validatedData['tanda_tangan'] = $request->file('tanda_tangan')->store('sertifikat-template');
        }

        $validatedData['is_default'] = $request->boolean('is_default');

        if ($validatedData['is_default']) {
            SertifikatTemplate::query()->where('id', '!=', $sertifikatTemplate->id)->update(['is_default' => false]);
        }

        $sertifikatTemplate->update($validatedData);

        return redirect('/admin/sertifikat-template')->with('success', 'Template Sertifikat Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SertifikatTemplate  $sertifikatTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(SertifikatTemplate $sertifikatTemplate)
    {
        if ($sertifikatTemplate->sertifikats()->exists()) {
            return back()->with('error', 'Template tidak dapat dihapus karena sudah dipakai oleh sertifikat yang diterbitkan.');
        }

        if ($sertifikatTemplate->logo) {
            Storage::delete($sertifikatTemplate->logo);
        }
        if ($sertifikatTemplate->tanda_tangan) {
            Storage::delete($sertifikatTemplate->tanda_tangan);
        }

        $sertifikatTemplate->delete();

        return redirect('/admin/sertifikat-template')->with('success', 'Template Sertifikat Berhasil Dihapus');
    }
}
