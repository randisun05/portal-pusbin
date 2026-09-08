<?php

namespace App\Http\Controllers\Public;

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

        return view('public.berita.posts', [
            "title" => "Daftar Publikasi" . $title,
            "posts" => Post::latest()->filter(request(['search', 'category', 'author']))->paginate(6)->withQueryString(),
            "categories" => Category::all(),
            "search" => request('search'),
            "categorySlug" => request('category'),
        ]);
    }


    public function show(Post $post)
    {
        return view('public.berita.post', [
            "title" => "Publikasi",
            "post" => $post

        ]);
    }


}
