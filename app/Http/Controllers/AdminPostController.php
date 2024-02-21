<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;


class AdminPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.posts.index', [
            "posts" => Post::all(),
            "sum" => Post::count(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create', [
            'categories' => Category::all()
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

// return $request->file('image')->store('post-image');
        $validateData = $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'category_id' => 'required',
            'image' => 'image|file|max:1024',
            'namadocument' => '',
            'document' => 'file|mimetypes:application/pdf|max:2048',
            'body' => 'required'
        ]);


        // $validateData['slug'] = Str::slug($request->title,'-');
        if($request->file('image')){
            $validateData['image'] = $request->file('image')->store('post-image');
        }

        if($request->file('document')){
            $validateData['document'] = $request->file('document')->store('post-document');
        }
        $validateData['user_id'] = auth()->user()->id;
        $validateData['excerpt'] = Str::limit(strip_tags($request->body), 200, '...');


        Post::create($validateData);

        return redirect('/admin/publikasi')->withSuccess('Publikasi Berhasil Dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {

        return view('admin.posts.show', [
            'post' => $post,
            'title' => "Berita"
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {

        return view('admin.posts.edit',[
            'post' => $post,
            'categories' => Category::all()
           ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $rules = [
            'title' => 'required',
            'category_id' => 'required',
            'category_id' => 'required',
            'image' => 'image|file|max:1024',
            'namadocument' => '',
            'document' => 'file|mimetypes:application/pdf|max:2048',
            'body' => 'required',
        ];

        // if($request->slug != $post->slug){
        //     $rules['slug'] = 'required|unique:posts';
        // }

        $validateData = $request->validate($rules);

        if($request->file('image')){
            if($request->oldImage){

                Storage::delete($request->oldImage);

            }
            $validateData['image'] = $request->file('image')->store('post-image');
        }


        if($request->file('document')){
            if($request->oldDocument){

                Storage::delete($request->oldDocument);

            }
            $validateData['document'] = $request->file('document')->store('post-document');
        }

        $validateData['user_id'] =auth()->user()->id;
        $validateData['excerpt'] = Str::limit(strip_tags($request->body), 200, '...');

        Post::where('id', $post->id)
                ->update($validateData);

        return redirect('/admin/publikasi')->withSuccess('Publikasi Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        if($post->image){
            Storage::delete($post->image);
        }
        Post::destroy($post->id);
        return redirect('/admin/publikasi')->withSuccess('Publikasi Berhasil Dihapus');

    }


    // public function checkSlug(Request $request)
    // {
    //     $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
    //     return response()->json(['slug' => $slug]);
    // }

    public function checkSlug(Request $request)
    {

        $slug = SlugService::createSlug (Post::class, 'slug', $request->title);

        return response()->json(['slug' => $slug]);
    }


}
