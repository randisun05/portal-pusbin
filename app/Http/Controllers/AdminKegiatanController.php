<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

class AdminKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.kegiatan.index', [
            "kegiatans" => Kegiatan::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.kegiatan.create', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'nama'  => 'Required',
            'waktu' => [
                'required',
                'date',
                'after_or_equal:today', // Memastikan waktu setidaknya sama dengan hari ini
            ],
            'link'  => 'Required',
            'jenis'  => 'Required',
            'image'  => 'Required',
        ]);

        if ($request->file('image')) {
            $image = $request->file('image')->store('post-image');
        }

        $slug = strtolower(str_replace(' ', '-', $request->nama));
        $original_slug = $slug;
        $count = 1;

        // Cek apakah slug sudah ada dalam database
        while (Kegiatan::where('slug', $slug)->exists()) {
            $slug = $original_slug . '-' . $count;
            $count++;
        }

        Kegiatan::create([
            'nama'  => $request->nama,
            'waktu'  => $request->waktu,
            'jenis'  => $request->jenis,
            'image'  => $image,
            'link'  => $request->link,
            'slug'  => $slug,
        ]);


        return redirect()->to('/admin/kegiatan')->with('success', 'Kegiatan Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function show(Kegiatan $kegiatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Kegiatan $kegiatan)
    {

        return view('admin.kegiatan.edit', [
            'kegiatan' => $kegiatan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $request->validate([
            'nama'  => 'Required',
            'waktu' => [
                'required',
                'date',
                'after_or_equal:today', // Memastikan waktu setidaknya sama dengan hari ini
            ],
            'link'  => 'Required',
            'jenis'  => 'Required',
            'status'  => 'Required',
        ]);


        if ($request->file('image')) {
            $image = $request->file('image')->store('post-image');
        }

        $slug = strtolower(str_replace(' ', '-', $request->nama));
        $original_slug = $slug;
        $count = 1;

        // Cek apakah slug sudah ada dalam database
        while (Kegiatan::where('slug', $slug)->exists()) {
            $slug = $original_slug . '-' . $count;
            $count++;
        }

        if ($request->file('image')) {
            $image = $request->file('image')->store('post-image');
            Kegiatan::where('id', $id)->update([
                'nama'  => $request->nama,
                'waktu'  => $request->waktu,
                'jenis'  => $request->jenis,
                'image'  => $image,
                'link'  => $request->link,
                'slug'  => $slug,
            ]);
        } else {

            Kegiatan::where('id', $id)->update([
                'nama'  => $request->nama,
                'waktu'  => $request->waktu,
                'jenis'  => $request->jenis,
                'link'  => $request->link,
                'slug'  => $slug,
            ]);
        }

        return redirect('/admin/kegiatan')->with('success', 'Kegiatan Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kegiatan $kegiatan)
    {
        Kegiatan::destroy($kegiatan->id);
        return redirect('/admin/kegiatan')->with('success', 'Kegiatan Berhasil Dihapus');
    }
}
