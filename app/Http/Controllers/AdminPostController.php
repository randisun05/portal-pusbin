<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;


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
            "posts" => Post::latest()->paginate(10),
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

        $validateData = $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'image' => '|image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
            'body' => 'required'

        ]);

        $today = Carbon::now()->format('l, d F Y H:i:s');

        $slug = strtolower(str_replace(' ', '-', $request->title));
        $originalSlug = $slug;
        $counter = 1;

        // Check if the generated slug is unique, if not, append a number
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }


        // $validateData['slug'] = Str::slug($request->title,'-');
        if($request->file('image')){
            $validateData['image'] = $request->file('image')->store('post-image');
        }

        if($request->file('document')){
            $validateData['document'] = $request->file('document')->store('post-document');
        }

        if($request->file('document')){
            $validateData['document'] = $request->file('document')->store('post-document');
        }

        if($request->has('link')) {
            $validateData['link'] = $request->input('link');
        }

        $validateData['user_id'] = auth()->user()->id;
        $validateData['excerpt'] = Str::limit(strip_tags($request->body), 200, '...');
        $validateData['publish_at'] = $today;
        $validateData['slug'] = $slug;

        return $validateData;
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
            'title' => "Publikasi"
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
            'body' => 'required',
        ];

        $validateData = $request->validate($rules);

        $slug = strtolower(str_replace(' ', '-', $request->title));
        $originalSlug = $slug;
        $counter = 1;

        if($request->title === $post->title){
            $validateData['slug'] = $slug;
        } else {

            // Check if the generated slug is unique, if not, append a number
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
            $validateData['slug'] = $slug;
             }

                }

        if($request->file('image')){
            if($request->oldImage){
                Storage::delete($request->oldImage);
            }
            $validateData['image'] = $request->file('image')->store('post-image');
        }

        if($request->file('document')){
            if($request->oldDoc){
                Storage::delete($request->oldDoc);
            }
            $validateData['document'] = $request->file('document')->store('post-document');
        }

        $validateData['user_id'] =auth()->user()->id;
        $validateData['excerpt'] = Str::limit(strip_tags($request->body), 200, '...');

        if($request->has('link')) {
            $validateData['link'] = $request->input('link');
        }

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

    //     $slug = SlugService::createSlug (Post::class, 'slug', $request->title);
    //     return response()->json(['slug' => $slug]);
    // }


}
