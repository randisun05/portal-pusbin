<?php

namespace App\Http\Controllers\Public;

use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Kegiatan;
use App\Models\Konsultasi;
use App\Models\KodeKonsultasi;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Mail\SendEmailKonsultasi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Concerns\GuardsAgainstSpam;

class KonsultasiController extends Controller
{
    use GuardsAgainstSpam;

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
     * Form pengajuan tiket konsultasi (tanya-jawab) oleh pemohon.
     */
    public function createTiket()
    {
        return view('public.konsultasi.usul', [
            'title' => 'Ajukan Konsultasi',
            'kode' => KodeKonsultasi::orderBy('id')->get(),
        ]);
    }

    /**
     * Simpan usulan konsultasi, terbitkan nomor tiket, kirim email (jika bisa).
     */
    public function storeTiket(Request $request)
    {
        $data = $request->validate([
            'nip' => 'required|digits:18',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'instansi' => 'required|string|max:255',
            'kode_id' => 'required|exists:kode_konsultasis,id',
            'deskripsi' => 'required|string|max:2000',
            'jadwal' => 'required|date|after_or_equal:today',
        ]);

        if ($this->isSpamSubmission($request)) {
            return redirect('/konsultasi/usul')->withSuccess('Usulan konsultasi diterima.');
        }

        $kode = KodeKonsultasi::findOrFail($data['kode_id']);
        $data['tiket'] = Konsultasi::buatNomorTiket($kode->kode);

        Konsultasi::create($data);

        try {
            Mail::to($data['email'])->send(new SendEmail([
                'nip' => $data['nip'],
                'nama' => $data['nama'],
                'email' => $data['email'],
                'tiket' => $data['tiket'],
            ]));
        } catch (\Throwable $e) {
            Log::warning('Email tiket konsultasi gagal dikirim.', ['tiket' => $data['tiket'], 'error' => $e->getMessage()]);
        }

        return redirect('/konsultasi/tiket?tiket=' . $data['tiket']);
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
        'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
    ]);

    if ($this->isSpamSubmission($request)) {
        return redirect()->route('public.konsultasi.index')->withSuccess('Pendaftaran berhasil, cek email anda!');
    }

     // Memeriksa apakah ada entri dengan kegiatan yang sama dan ID kegiatan yang sama
     $existingEntry = Absensi::where('kegiatan_id', $request->kegiatan_id)
     ->where('nip', $request->nip)
     ->first();

     if ($existingEntry) {
     return redirect()->back()->with('error', 'Anda sudah terdaftar untuk kegiatan ini.');
     }

       $absensi = Absensi::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'kegiatan_id' => $request->kegiatan_id,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'instansi' => $request->instansi,
        ]);

        if ($request->hasFile('lampiran')) {
            $absensi->simpanLampiran($request->file('lampiran'));
        }

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
