<?php

namespace App\Http\Controllers\Public;

use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Mail\SendEmailKegiatan;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\GuardsAgainstSpam;

class PublicKegiatanController extends Controller
{
    use GuardsAgainstSpam;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $base = Kegiatan::where('jenis', '!=', 'Konsultasi')->where('jenis', '!=', 'Uji Kompetensi');

        $daftarJenis = (clone $base)->select('jenis')->distinct()->pluck('jenis')->filter()->values();

        $kegiatans = (clone $base)->when($request->jenis, function ($query, $jenis) {
                $query->where('jenis', $jenis);
            })->latest()->paginate(6)->withQueryString();

        foreach ($kegiatans as $kegiatan) {
            $waktu = Carbon::parse($kegiatan->waktu);
            // Set timezone ke Asia/Jakarta agar sesuai dengan waktu Indonesia Barat
            $waktu->setTimezone('Asia/Jakarta');
            // Format waktu sesuai dengan format bahasa Indonesia
            $waktuFormatted = $waktu->isoFormat('D MMMM YYYY, HH:mm');
            // Update waktu dalam objek $kegiatan
            $kegiatan->waktu = $waktuFormatted;
        }

        return view('public.kegiatan.index', [
            'kegiatans' => $kegiatans,
            'daftarJenis' => $daftarJenis,
            'jenisAktif' => $request->jenis,
            'title' => "Kegiatan Selanjutnya"
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Kegiatan $kegiatan)
    {
        return view('public.kegiatan.create', [
            'title' => $kegiatan->nama,
            'kegiatan' => $kegiatan
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
         // Validate request including file validation
      $request->validate([
        'nip' => 'required|',
        'nama' => 'required|',
        'kegiatan_id' => 'required',
        'email' => 'required|email',
        'jabatan' => 'required|',
        'instansi' => 'required|',
    ]);

    if ($this->isSpamSubmission($request)) {
        return redirect()->route('public.kegiatan.index')->withSuccess('Pendaftaran berhasil! Cek email Anda untuk konfirmasi.');
    }

    // Memeriksa apakah ada entri dengan kegiatan yang sama dan ID kegiatan yang sama
        $existingEntry = Absensi::where('kegiatan_id', $request->kegiatan_id)
        ->where('nip', $request->nip)
        ->first();

        if ($existingEntry) {
        return redirect()->back()->with('error', 'Anda sudah melakukan pendaftaran untuk kegiatan ini.');
        }

       Absensi::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'kegiatan_id' => $request->kegiatan_id,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'instansi' => $request->instansi,
        ]);

        $data = Absensi::where('nip', $request->nip)->with('kegiatan')->latest()->first();

        try {
            Mail::to($data->email)->send(new SendEmailKegiatan($data));
        } catch (\Throwable $e) {
            // Pendaftaran tetap berhasil walau email konfirmasi gagal terkirim
        }

        return redirect()->route('public.kegiatan.index')->withSuccess('Pendaftaran berhasil! Cek email Anda untuk konfirmasi.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Kegiatan $kegiatan)
    {
        return view('public.kegiatan.show', [
            'title' => $kegiatan->nama,
            'kegiatan' => $kegiatan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
