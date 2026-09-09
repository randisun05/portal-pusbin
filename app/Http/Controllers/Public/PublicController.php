<?php

namespace App\Http\Controllers\Public;

use App\Models\Post;
use App\Models\Profil;
use App\Models\Layanan;
use App\Models\Kegiatan;
use App\Models\MisiItem;
use App\Models\highlight;
use App\Models\PesanKontak;
use App\Models\OrganisasiUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class PublicController extends Controller
{

    public function web()
    {
        $posts = Post::with('category')->latest()->paginate(3);
        $layanans = Layanan::whereNot('nama','web')->where('status',1)->latest()->get();
        $kegiatans = Kegiatan::where('jenis','!=', 'Konsultasi')->where('jenis','!=', 'Uji Kompetensi')->latest()->paginate(6);
        foreach ($kegiatans as $kegiatan) {
            $waktu = Carbon::parse($kegiatan->waktu);
            // Set timezone ke Asia/Jakarta agar sesuai dengan waktu Indonesia Barat
            $waktu->setTimezone('Asia/Jakarta');
            // Format waktu sesuai dengan format bahasa Indonesia
            $waktuFormatted = $waktu->isoFormat('D MMMM YYYY, HH:mm');
            // Update waktu dalam objek $kegiatan
            $kegiatan->waktu = $waktuFormatted;
        }

        return view('portal.index', [
            "posts" => $posts,
            "layanans" => $layanans,
            'kegiatans' => $kegiatans,
            'profil' => Profil::current(),
            'jumlahOrganisasi' => OrganisasiUnit::count(),
            'jumlahLayanan' => Layanan::where('status', 1)->count(),
            'jumlahKegiatan' => Kegiatan::count(),
            'jumlahPublikasi' => Post::count(),
        ]);
    }

    public function notfound()
    {

       return view('errors.404',[
        'title' => "Page Not Found"
       ]);
    }


    public function about()
    {
        return view('public.about.tentang-kami',[
            'title' => "Tentang Kami",
            'profil' => Profil::current(),
            'jumlahLayanan' => Layanan::where('status', 1)->count(),
            'jumlahKegiatan' => Kegiatan::count(),
            'jumlahPublikasi' => Post::count(),
            'jumlahOrganisasi' => OrganisasiUnit::count(),
        ]);
    }

    public function kapus()
    {
        $kapus = OrganisasiUnit::whereNull('parent_id')->orderBy('urutan')->first();

        return view('public.about.kepala',[
            'title' => "Direktur Jabatan Fungsional Manajemen Aparatur Sipil Negara",
            'kapus' => $kapus,
        ]);
    }

    public function struktur()
    {
        $tree = OrganisasiUnit::with('children.children.children')
            ->whereNull('parent_id')
            ->orderBy('urutan')
            ->get();

        $units = OrganisasiUnit::orderBy('unit')->orderBy('urutan')->get();

        return view('public.about.struktur',[
            'title' => "Struktur Organisasi",
            'tree' => $tree,
            'units' => $units,
            'daftarUnit' => $units->pluck('unit')->filter()->unique()->values(),
        ]);
    }

    public function visimisi()
    {
        return view('public.about.visi-misi',[
            'title' => "Visi Misi",
            'profil' => Profil::current(),
            'misis' => MisiItem::orderBy('urutan')->get(),
        ]);
    }
    public function kebutuhan()
    {

       return view('public.layanan.pengajuan-rekomendasi',[
        'title' => "Rekomendasi Kebutuhan Jabatan Fungsional Kepegawaian",
       ]);
    }

    public function pengembangan()
    {
        return view('public.layanan.pengembangan-kompetensi',[
            'title' => "Pengembangan Kompetensi Jabatan Fungsional Kepegawaian",
        ]);
    }

    public function ujikom()
    {

        return view('public.layanan.pendaftaran-ukom',[
            'title' => "Uji Kompetensi Jabatan Fungsional Kepegawaian",
        ]);

    }

    public function audiwan()
    {
        return view('public.layanan.perpindahan-audiwan',[
            'title' => "Perpindahan Audiwan Ke Jabatan Fungsional Kepegawaian Lainnya",
        ]);
    }

    public function konversiAk()
    {
        return view('public.layanan.konversi-ak',[
            'title' => "Konversi Angka Kredit Jabatan Fungsional Kepegawaian",
        ]);
    }

    public function pengusulanPak()
    {
        return view('public.layanan.pengusulan-pak',[
            'title' => "Pengusulan Penetapan Angka Kredit (PAK)",
        ]);
    }

    public function perubahanNomenklatur()
    {
        return view('public.layanan.perubahan-nomenklatur',[
            'title' => "Perubahan Nomenklatur Jabatan Fungsional Kepegawaian",
        ]);
    }

    public function kontak()
    {
        return view('public.about.kontak',[
            'title' => "Kontak Kami",
            'profil' => Profil::current(),
        ]);
    }

    public function kontakStore(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'telepon' => 'nullable',
            'subjek' => 'nullable',
            'pesan' => 'required',
        ]);

        PesanKontak::create($validatedData);

        return redirect('/about/kontak-kami')->with('success', 'Terima kasih, pesan Anda berhasil terkirim. Kami akan segera merespon.');
    }


}
