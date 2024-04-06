<?php

namespace App\Http\Controllers\Admin;

use App\Models\highlight;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;

class HighlightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.highlight.index', [
            "highlights" => highlight::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.highlight.create', [
            'title' => "Highlight",
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
        $validatedData = $request ->validate([
            "*" => 'required',
            'image' => 'image|file|max:1024',
           ]);

        $file = $request->file('image')->store('post-image');


        $validatedData['image'] = $file;


        highlight::create($validatedData);


           return redirect()->to('/admin/highlight')->with('success', 'Highlight Berhasil Dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        {

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(highlight $highlight)
    {
        return view('admin.highlight.edit',[
            'highlights' => highlight::all(),
            'highlight' => $highlight
           ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, highlight $highlight)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'desc' => 'required',
            'image' => 'image|file|max:1024',

        ]);

        if($request->file('image')){
            if($request->oldImage){
                Storage::delete($request->oldImage);
            }
            $validateData['image'] = $request->file('image')->store('post-image');
        }

        highlight::where('id', $highlight->id)
                ->update($validateData);

        return redirect('/admin/highlight')->with('success','Highlight Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(highlight $highlight)
    {
        if($highlight->image){
            Storage::delete($highlight->image);
        }
       highlight::destroy($highlight->id);
        return redirect('/admin/highlight')->with('success','Highlight Berhasil Dihapus');
    }
}
