<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kegiatan;
use App\Models\MateriPaparan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'batas_presensi' => 'nullable|date',
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
            'batas_presensi'  => $request->batas_presensi,
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
            'batas_presensi' => 'nullable|date',
            'link'  => 'Required',
            'jenis'  => 'Required',
            'status'  => 'Required',
        ]);


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
                'batas_presensi'  => $request->batas_presensi,
                'jenis'  => $request->jenis,
                'image'  => $image,
                'link'  => $request->link,
                'slug'  => $slug,
            ]);
        } else {

            Kegiatan::where('id', $id)->update([
                'nama'  => $request->nama,
                'waktu'  => $request->waktu,
                'batas_presensi'  => $request->batas_presensi,
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

    /**
     * Display the materi paparan list for the given kegiatan.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function materiIndex(Kegiatan $kegiatan)
    {
        return view('admin.kegiatan.materi', [
            'kegiatan' => $kegiatan,
            'materis' => $kegiatan->materis,
        ]);
    }

    /**
     * Store a newly uploaded materi paparan for the given kegiatan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function materiStore(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'judul' => 'required',
            'file' => 'required|file|mimes:pdf,ppt,pptx,doc,docx|max:20480',
            'keterangan' => 'nullable',
        ]);

        $file = $request->file('file')->store('materi-paparan');

        MateriPaparan::create([
            'kegiatan_id' => $kegiatan->id,
            'judul' => $request->judul,
            'file' => $file,
            'keterangan' => $request->keterangan,
            'urutan' => $kegiatan->materis()->count(),
        ]);

        return redirect("/admin/kegiatan/{$kegiatan->id}/materi")->with('success', 'Materi Paparan Berhasil Ditambah');
    }

    /**
     * Remove the given materi paparan.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @param  \App\Models\MateriPaparan  $materi
     * @return \Illuminate\Http\Response
     */
    public function materiDestroy(Kegiatan $kegiatan, MateriPaparan $materi)
    {
        if ($materi->kegiatan_id !== $kegiatan->id) {
            abort(404);
        }

        Storage::delete($materi->file);
        $materi->delete();

        return redirect("/admin/kegiatan/{$kegiatan->id}/materi")->with('success', 'Materi Paparan Berhasil Dihapus');
    }
}
