<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\Absensi;
use App\Models\Kegiatan;
use App\Models\Konsultasi;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use function Ramsey\Uuid\v1;
use Illuminate\Http\Request;
use App\Models\KodeKonsultasi;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class AdminKonsultasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $absensis = Absensi::latest();
        $ids = Kegiatan::where('jenis', '!=', 'Konsultasi')->pluck('id');

            if (request('search')) {
                // Menambahkan kondisi pencarian jika ada parameter 'search' yang dikirimkan
                $absensis->where('kegiatan_id', 'like', '%' . request('search') . '%');
            }

            // Menambahkan kondisi whereNotIn setelah penanganan pencarian
            $absensis->whereNotIn('kegiatan_id', $ids);
            $absensis = $absensis->paginate(10);

            return view('admin.konsultasi.index', [
                'kegiatans' => Kegiatan::where('jenis', 'Konsultasi')->get(),
                "absensis" => $absensis
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
        // return $request;


        $kode = KodeKonsultasi::where('id', $request->kode_id)->get('kode');
        do {
            $array = [1, 2, 3, 4, 5, 6, 7, 8 ,9, 0];
            $random = Arr::random($array, 4);
            $tiket = $kode[0]->kode;
            foreach($random as $r){
                $tiket = $tiket . $r;
            }
        } while(Konsultasi::where('tiket', $tiket)->exists());

        // $array = [1, 2, 3, 4, 5, 6, 7, 8 ,9, 0];
        // $random = Arr::random($array, 4);
        // $tiket = $kode;
        // foreach($random as $r){
        //     $tiket = $tiket . $r;
        // }

        $validatedData = $request->validate([
            "*" => 'required',
        ]);

        $validatedData['tiket'] = $tiket;

        // if($request->tiket = ""){
        //     $validateData['tiket'] = $tiket;
        // }

        Konsultasi::create($validatedData);
        $data = [
            'nip' => $request->nip,
            'email' => $request->nip,
            'tiket' => $tiket
        ];

        Mail::to($data['email'])->send(new SendEmail($data));

        return view('public.konsultasi.tiket',[
            "tiket" => $tiket,
            "title" => "Nomor Tiket",
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Konsultasi  $konsultasi
     * @return \Illuminate\Http\Response
     */
    public function show(Konsultasi $konsultasi)
    {

        return view('public.konsultasi.show', [
            'title' => "Jawaban",
            'konsultasi' => $konsultasi,
        ]);
    }

    public function search(Request $request)
    {
        $konsultasi = null;

        if ($request->has('search')) {
            $konsultasi = Konsultasi::where('tiket','LIKE','%'.$request->search)->first();
        }

        return view('public.konsultasi.show',['konsultasi'=>$konsultasi,  'title' => "Cari Konsultasi",]);
    }

    public function tiket(Request $request)
    {
        return view('public.konsultasi.tiket', [
            'tiket' => $request->query('tiket'),
            'title' => "Nomor Tiket",
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Konsultasi  $konsultasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Konsultasi $konsultasi)
    {
        return view('admin.konsultasi.edit', [
            'konsultasi' => $konsultasi
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Konsultasi  $konsultasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Konsultasi $konsultasi)
    {
        $validateData = $request->validate([
            'jadwalfix' => 'required',
            'link' => 'required',
            'pic' => 'required',
        ]);

        $validateData['jawab'] = 1;

        Konsultasi::where('id', $konsultasi->id)
                ->update($validateData);

        return redirect('/admin/konsultasi/')->with('success','Konsultasi Telah Dijawab');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Konsultasi  $konsultasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Konsultasi $konsultasi)
    {
        // dd($layanan);
        Konsultasi::destroy($konsultasi->id);

        return redirect('/admin/konsultasi')->with('success','Usul Konsultasi Berhasil Dihapus');
    }



}
