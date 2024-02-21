<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LayananController extends Controller
{
    public function index()
    {
        return view('admin\daftarlayanan', [
            "layanans" => Layanan::all()
        ]);
    }

    public function store(Request $request)

    {

        return $request;
        // return $request->file('image')->store('post-image');

        $validatedData = $request ->validate([
        "*" => 'required',
        'image' => 'image|file|max:1024',
       ]);

    //    return $validatedData;

    // if($request->file('image')){
    //     $validateData['image'] = $request->file('image')->store('post-image');
    // }


       Layanan::create($validatedData);


       return redirect()->to('/admin/layanan')->with('success', 'Registrasi Success, Please Login');
    }

}
