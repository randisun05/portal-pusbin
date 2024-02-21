<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\highlight;

class PostController extends Controller
{
    public function index()
    {
        $title='';
        if(request('category')) {
            $category = Category::firstWhere('slug', request('category'));
            $title= ' in ' . $category->name ;
        }

        if(request('author')) {
            $author = User::firstWhere('username', request('author'));
            $title= ' by ' . $author->name ;
        }

        return view('berita.posts', [
            "title" => "Daftar Publikasi" . $title,
            "posts" => Post::latest()->filter(request(['search', 'category', 'author']))->paginate(6)
            // "posts" => Post::latest()->paginate(6)
            // "posts" => $posts->get()

        ]);
    }


    public function show(Post $post)
    {
        return view('berita.post', [
            "title" => "Publikasi",
            "post" => $post

        ]);
    }

    public function index1()
    {

        $highlights = highlight::orderBy('created_at', 'desc') // Urutkan berdasarkan waktu pembuatan (atau kolom lain yang sesuai)
        ->take(3) // Ambil tiga data terbaru
        ->get(); // Lakukan query dan dapatkan hasilnya
        $active = highlight::latest()->first();

        return view('portal.index', [
            "posts" => Post::all(),
            "posts" => Post::latest()->paginate(6),
            "layanans" => Layanan::all(),
            "highlights" =>  $highlights,
            "active" => $active,
        ]);
    }
    public function index2()
    {

        return view('portal.welcome', [
            // "posts" => Post::all(),
            // "posts" => Post::latest()->paginate(6),
            "layanans" => Layanan::all(),


        ]);
    }



    public function store(Request $request)
    {


        $validatedData = $request ->validate([
        "*" => 'required',
       ]);

    //    return $validatedData;


       Post::create();


       return redirect()->to('/admin/berita')->with('success', 'Registrasi Success, Please Login');
    }


}
