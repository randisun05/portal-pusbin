<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;


class AdminLayananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.layanan.index', [
            "layanans" => Layanan::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.layanan.create', [

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
        // ddd($request);

        $validatedData = $request ->validate([
            "*" => 'required',
            'image' => 'image|file|max:1024',
           ]);

        $file = $request->file('image')->store('post-image');

        $validatedData['image'] = $file;

        Layanan::create($validatedData);


           return redirect()->to('/admin/layanan')->with('success', 'Layanan Berhasil Dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Layanan  $layanan
     * @return \Illuminate\Http\Response
     */
    public function show(Layanan $layanan)
    {
        {
            return view('admin.layanan.show', [
                'layanans' => Layanan::all(),
                'layanan' => $layanan
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Layanan  $layanan
     * @return \Illuminate\Http\Response
     */
    public function edit(Layanan $layanan)
    {

        return view('admin.layanan.edit',[
            'layanans' => Layanan::all(),
            'layanan' => $layanan
           ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Layanan  $layanan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Layanan $layanan)
    {

        $validateData = $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'link' => 'required',
            'image' => 'image|file|max:1024',
            'aktif' => 'required',

        ]);

        if($request->file('image')){
            if($request->oldImage){
                Storage::delete($request->oldImage);
            }
            $validateData['image'] = $request->file('image')->store('post-image');
        }

        Layanan::where('id', $layanan->id)
                ->update($validateData);

        return redirect('/admin/layanan')->with('success','Layanan Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Layanan  $layanan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Layanan $layanan)
    {
        if($layanan->image){
            Storage::delete($layanan->image);
        }
        Layanan::destroy($layanan->id);
        return redirect('/admin/layanan')->with('success','Layanan Berhasil Dihapus');
    }
}
