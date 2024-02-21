<?php

namespace App\Http\Controllers;

use App\Models\Survei;
use App\Models\SurveiGroup;
use Illuminate\Http\Request;

class SurveiPublicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('survei\index', [
            'title' => "Daftar Survei Pusat Pembinaan Jabatan Fungsional Kepegawaian",
            'surveis' => Survei::get(),
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

        $title = Survei::where('id',$id)->value('title');
        $type = Survei::where('id',$id)->value('type');
        $survei = SurveiGroup::with('indikator')->where('survei_id',$id)->get();
        
        return view('survei\create', [
            'title' => $title,
            'type' => $type,
            'surveis' => $survei,
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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
