<?php

namespace App\Http\Controllers\Public;

use App\Models\Post;
use App\Models\Layanan;
use App\Models\Comment;
use App\Models\Reaction;
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
        $post->increment('views');

        $related = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest()
            ->limit(3)
            ->get();

        return view('public.berita.post', [
            "title" => "Publikasi",
            "post" => $post,
            "comments" => $post->approvedComments()->get(),
            "reactionCounts" => $post->reactionCounts(),
            "myReaction" => Reaction::where('post_id', $post->id)->where('session_id', session()->getId())->value('type'),
            "related" => $related,

        ]);
    }

    public function storeComment(Request $request, Post $post)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'email' => 'nullable|email',
            'body' => 'required|max:2000',
        ]);

        $validated['post_id'] = $post->id;

        Comment::create($validated);

        return redirect('/publikasi/' . $post->slug . '#komentar')->with('success', 'Komentar Anda berhasil dikirim dan menunggu persetujuan admin.');
    }

    public function react(Request $request, Post $post)
    {
        $request->validate([
            'type' => 'required|in:' . implode(',', \App\Models\Reaction::TYPES),
        ]);

        Reaction::updateOrCreate(
            ['post_id' => $post->id, 'session_id' => session()->getId()],
            ['type' => $request->type]
        );

        return response()->json([
            'counts' => $post->reactionCounts(),
        ]);
    }


}
