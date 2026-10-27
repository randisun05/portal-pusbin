<?php

namespace App\Http\Controllers\Admin;

use App\Models\PengaturanSertifikat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPengaturanSertifikatController extends Controller
{
    /**
     * Display the settings form.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('admin.pengaturan-sertifikat.edit', [
            'title' => 'Pengaturan Nomor Sertifikat',
            'pengaturan' => PengaturanSertifikat::current(),
        ]);
    }

    /**
     * Update the settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'prefix' => 'required|string|max:20',
            'digit_urut' => 'required|integer|min:1|max:10',
            'reset_tahunan' => 'nullable|boolean',
        ]);

        $validatedData['reset_tahunan'] = $request->boolean('reset_tahunan');

        $pengaturan = PengaturanSertifikat::current();
        $pengaturan->fill($validatedData);
        $pengaturan->save();

        return redirect('/admin/pengaturan-sertifikat')->with('success', 'Pengaturan Nomor Sertifikat Berhasil Diupdate');
    }
}
