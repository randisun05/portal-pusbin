<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jdihjfk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminJdifjfkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.jdihjfk.index', [
            'datas' => Jdihjfk::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.jdihjfk.create', [

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

           ]);

        $file = $request->file('image')->store('post-image');

        $validatedData['image'] = $file;

        Jdihjfk::create($validatedData);

           return redirect()->to('/admin/jdihjfk')->with('success', 'Peraturan Berhasil Dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data = Jdihjfk::find($id);
        return view('admin.jdihjfk.edit',[
            'data' => $data
           ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jdihjfk $jdihjfk)
    {

        $validateData = $request->validate([
            'title' => 'required',
            'deskripsi' => 'required',
            'link' => 'required',
            'image' => 'image|file|max:1024',

        ]);

        if($request->file('image')){
            if($request->oldImage){
                Storage::delete($request->oldImage);
            }
            $validateData['image'] = $request->file('image')->store('post-image');
        }

        Jdihjfk::where('id', $jdihjfk->id)
                ->update($validateData);

        return redirect('/admin/jdihjfk')->with('success','Peraturan Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jdihjfk $data, $id)
    {

        if($data->image){
        Storage::delete($data->image);
        }
        
        Jdihjfk::destroy($id);
        return redirect('/admin/jdihjfk')->with('success','Peraturan Berhasil Dihapus');
    }
}

