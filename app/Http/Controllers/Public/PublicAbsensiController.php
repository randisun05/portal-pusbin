<?php

namespace App\Http\Controllers\Public;

use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Mail\SendEmailAbsensi;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\GuardsAgainstSpam;

class PublicAbsensiController extends Controller
{
    use GuardsAgainstSpam;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kegiatans = Kegiatan::where('jenis','!=', 'Konsultasi')->latest()->paginate(6);

        foreach ($kegiatans as $kegiatan) {
            $waktu = Carbon::parse($kegiatan->waktu);
            // Set timezone ke Asia/Jakarta agar sesuai dengan waktu Indonesia Barat
            $waktu->setTimezone('Asia/Jakarta');
            // Format waktu sesuai dengan format bahasa Indonesia
            $waktuFormatted = $waktu->isoFormat('D MMMM YYYY, HH:mm');
            // Update waktu dalam objek $kegiatan
            $kegiatan->waktu = $waktuFormatted;
        }

        return view('public.absensi.select', [
            'kegiatans' => $kegiatans,
            'title' => "Absensi Kegiatan"
        ]);

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Kegiatan $kegiatan)
    {
        return view('public.absensi.create', [
            'title' => "Absensi Kegiatan     {$kegiatan->nama}",
            'kegiatan' => $kegiatan,
            'presensiTertutup' => $kegiatan->isPresensiTertutup(),
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
        'rating' => 'required|integer|min:1|max:4',
        'saran' => 'nullable|string|max:2000',
        'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
    ]);

    $successMessage = 'Absensi berhasil! Cek email Anda untuk konfirmasi.';

    if ($this->isSpamSubmission($request)) {
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $successMessage]);
        }

        return redirect()->route('public.absensi.index')->withSuccess($successMessage);
    }

    $kegiatan = Kegiatan::find($request->kegiatan_id);
    if ($kegiatan && $kegiatan->isPresensiTertutup()) {
        $message = 'Batas waktu presensi untuk kegiatan ini sudah berakhir.';

        if ($request->wantsJson()) {
            return response()->json(['success' => false, 'message' => $message], 422);
        }

        return redirect()->back()->with('error', $message);
    }

    // Memeriksa apakah ada entri dengan kegiatan yang sama dan ID kegiatan yang sama
        $existingEntry = Absensi::where('kegiatan_id', $request->kegiatan_id)
        ->where('nip', $request->nip)
        ->first();

        if ($existingEntry) {
        $message = 'Anda sudah melakukan absensi untuk kegiatan ini.';

        if ($request->wantsJson()) {
            return response()->json(['success' => false, 'message' => $message], 422);
        }

        return redirect()->back()->with('error', $message);
        }


       $absensi = Absensi::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'kegiatan_id' => $request->kegiatan_id,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'instansi' => $request->instansi,
            'rating' => $request->rating,
            'saran' => $request->saran,
        ]);

        if ($request->hasFile('lampiran')) {
            $absensi->simpanLampiran($request->file('lampiran'));
        }

        $data = Absensi::where('nip', $request->nip)->where('kegiatan_id', $request->kegiatan_id)->with('kegiatan')->latest()->first();

        try {
            Mail::to($data->email)->send(new SendEmailAbsensi($data));
        } catch (\Throwable $e) {
            // Absensi tetap berhasil walau email konfirmasi gagal terkirim
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $successMessage]);
        }

        return redirect()->route('public.absensi.index')->withSuccess($successMessage);
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
