<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Jdihjfk;
use App\Models\Layanan;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Cari di seluruh konten publik (publikasi, FAQ, layanan, repository).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $posts = collect();
        $faqs = collect();
        $layanans = collect();
        $repositories = collect();

        if ($q !== '') {
            $posts = Post::where('title', 'like', "%{$q}%")
                ->orWhere('body', 'like', "%{$q}%")
                ->latest()
                ->limit(10)
                ->get();

            $faqs = Faq::where('pertanyaan', 'like', "%{$q}%")
                ->orWhere('jawaban', 'like', "%{$q}%")
                ->limit(10)
                ->get();

            $layanans = Layanan::where('status', 1)
                ->where(function ($query) use ($q) {
                    $query->where('nama', 'like', "%{$q}%")
                        ->orWhere('deskripsi', 'like', "%{$q}%");
                })
                ->limit(10)
                ->get();

            $repositories = Jdihjfk::published()
                ->where(function ($query) use ($q) {
                    $query->where('title', 'like', "%{$q}%")
                        ->orWhere('deskripsi', 'like', "%{$q}%");
                })
                ->limit(10)
                ->get();
        }

        $total = $posts->count() + $faqs->count() + $layanans->count() + $repositories->count();

        return view('public.search.index', [
            'title' => 'Hasil Pencarian',
            'q' => $q,
            'posts' => $posts,
            'faqs' => $faqs,
            'layanans' => $layanans,
            'repositories' => $repositories,
            'total' => $total,
        ]);
    }
}
