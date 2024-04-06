<?php

namespace App\Http\Controllers\Public;

use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Mail\SendEmailKonsultasi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class KonsultasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $kegiatans = Kegiatan::where('jenis', "Konsultasi")->latest()->paginate(3);

        foreach ($kegiatans as $kegiatan) {
            $waktu = Carbon::parse($kegiatan->waktu);
            // Set timezone ke Asia/Jakarta agar sesuai dengan waktu Indonesia Barat
            $waktu->setTimezone('Asia/Jakarta');
            // Format waktu sesuai dengan format bahasa Indonesia
            $waktuFormatted = $waktu->isoFormat('D MMMM YYYY, HH:mm');
            // Update waktu dalam objek $kegiatan
            $kegiatan->waktu = $waktuFormatted;
        }

        return view('public.konsultasi.index',[
        'kegiatans' => $kegiatans,
        'title' => "Konsultasi"
       ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Kegiatan $kegiatan)
    {
        // Session::flash('error', 'Silakan login terlebih dahulu.');

        return view('public.konsultasi.create', [
            'title' => "Daftar {$kegiatan->nama}",
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

     // Memeriksa apakah ada entri dengan kegiatan yang sama dan ID kegiatan yang sama
     $existingEntry = Absensi::where('kegiatan_id', $request->kegiatan_id)
     ->where('nip', $request->nip)
     ->first();

     if ($existingEntry) {
     return redirect()->back()->with('error', 'Anda sudah terdaftar untuk kegiatan ini.');
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


        Mail::to($data['email'])->send(new SendEmailKonsultasi($data));

        return redirect()->route('public.konsultasi.index')->withSuccess('Pendaftaran berhasil, cek email anda!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
