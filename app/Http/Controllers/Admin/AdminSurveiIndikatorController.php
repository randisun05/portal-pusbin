<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveiIndikator;
use Illuminate\Http\Request;

class AdminSurveiIndikatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.survei.indikator.index', [
            'datas' => SurveiIndikator::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.survei.indikator.create', [

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
            'title' => 'required',
           ]);

        SurveiIndikator::create($validatedData);
        return redirect()->to('/admin/surveiindikator')->with('success', 'Indikator Berhasil Dibuat');
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
        $data = SurveiIndikator::find($id);
        return view('admin.survei.indikator.edit',[
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
    public function update(Request $request, $id)
    {
        // return SurveiIndikator::all();

        $validateData = $request->validate([
            'title' => 'required',
        ]);



        SurveiIndikator::where('id', $id)
                ->update($validateData);

        return redirect('/admin/surveiindikator')->with('success','Indikator Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SurveiIndikator::destroy($id);
            return redirect('/admin/surveiindikator')->with('success','Indiktor Berhasil Dihapus');
    }
}
