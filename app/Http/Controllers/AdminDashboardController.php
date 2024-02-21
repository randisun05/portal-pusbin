<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\Post;
use App\Models\Layanan;
use App\Models\Konsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;



class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.dashboard.index', [
            "dashboards" => Dashboard::all(),


        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dashboard.create', [

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

        Dashboard::create($validatedData);

        return redirect()->to('/admin/dashboard')->with('success', 'Menambah Dashboard Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function show(Dashboard $dashboard)
    {
        return view('admin.dashboard.show', [
            'dashboards' => Dashboard::all(),
            'dashboard' => $dashboard
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function edit(Dashboard $dashboard)
    {
        return view('admin.dashboard.edit', [
            'dashboards' => Dashboard::all(),
            'dashboard' => $dashboard
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        $validateData = $request->validate([
            "*" => 'required',
            'image' => 'image|file|max:1024',

        ]);

        if($request->file('image')){
            if($request->oldImage){
                Storage::delete($request->oldImage);
            }
            $validateData['image'] = $request->file('image')->store('post-image');
        }

        Dashboard::where('id', $dashboard->id)
                ->update($validateData);

        return redirect('/admin/dashboard')->with('success','Dashboard Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */

    public function destroy(Dashboard $dashboard)
    {
        if($dashboard->image){
            Storage::delete($dashboard->image);
        }
        Dashboard::destroy($dashboard->id);
        return redirect('/admin/dashboard')->with('success','Dashboard Berhasil Dihapus');
    }


    public function home()
    {
        return view('admin.home', [
            "sum" => Post::count(),
            "sumumum" => Post::where('category_id',1)->count(),
            "sumpeng" => Post::where('category_id',2)->count(),
            "sumkegiatan" => Post::where('category_id',3)->count(),
            "sumlay" => Layanan::count(),
            "sumdash" => Dashboard::count(),
            "sumkonsul" => Konsultasi::count(),
            "konsuldilayani" => Konsultasi::where('pic')->count(),



        ]);
    }

}
