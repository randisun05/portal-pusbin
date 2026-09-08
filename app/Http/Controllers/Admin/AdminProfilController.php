<?php

namespace App\Http\Controllers\Admin;

use App\Models\Profil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminProfilController extends Controller
{
    /**
     * Show the form for editing the site profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('admin.profil.edit', [
            'title' => 'Profil Organisasi',
            'profil' => Profil::current(),
        ]);
    }

    /**
     * Update the site profile in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'tentang' => 'nullable',
            'visi' => 'nullable',
            'alamat' => 'nullable',
            'telepon' => 'nullable',
            'email' => 'nullable|email',
            'jam_operasional' => 'nullable',
            'maps_embed' => 'nullable',
            'instagram' => 'nullable',
            'facebook' => 'nullable',
            'youtube' => 'nullable',
            'twitter' => 'nullable',
        ]);

        $profil = Profil::first() ?? new Profil();
        $profil->fill($validatedData);
        $profil->save();

        return redirect('/admin/profil')->with('success', 'Profil Organisasi Berhasil Diupdate');
    }
}
