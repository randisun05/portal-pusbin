<?php

namespace App\Http\Controllers\Admin;

use App\Models\PesanKontak;
use App\Http\Controllers\Controller;

class AdminPesanKontakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pesankontak.index', [
            'pesans' => PesanKontak::latest()->get(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PesanKontak  $pesankontak
     * @return \Illuminate\Http\Response
     */
    public function show(PesanKontak $pesankontak)
    {
        if (! $pesankontak->dibaca) {
            $pesankontak->update(['dibaca' => true]);
        }

        return view('admin.pesankontak.show', [
            'pesan' => $pesankontak,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PesanKontak  $pesankontak
     * @return \Illuminate\Http\Response
     */
    public function destroy(PesanKontak $pesankontak)
    {
        $pesankontak->delete();

        return redirect('/admin/pesankontak')->with('success', 'Pesan Berhasil Dihapus');
    }
}
