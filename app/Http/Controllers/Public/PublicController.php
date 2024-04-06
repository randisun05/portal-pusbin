<?php

namespace App\Http\Controllers\Public;

use App\Models\Post;
use App\Models\Layanan;
use App\Models\highlight;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublicController extends Controller
{

    public function portal()
    {
       $layanans = Layanan::latest()->where('status','1')->get();
       return view('portal.welcome',[
        'layanans' => $layanans,
       ]);
    }

    public function web()
    {
        $posts = Post::with('category')->latest()->paginate(3);
        $layanans = Layanan::whereNot('nama','web')->where('status',1)->latest()->get();

        return view('portal.index', [
            "posts" => $posts,
            "layanans" => $layanans,
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
       ]);
    }

    public function kapus()
    {


       return view('public.about.kepala',[
        'title' => "Kepala Pusat Pembinaan Jabatan Fungsional Kepegawaian",
       ]);
    }

    public function struktur()
    {

       return view('public.about.struktur',[
        'title' => "Struktur Organisasi",
       ]);
    }

    public function visimisi()
    {

       return view('public.about.visi-misi',[
        'title' => "Visi Misi",
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

    public function kontak()
    {
        return view('public.about.kontak',[
            'title' => "Kontak Kami",
        ]);
    }


}
