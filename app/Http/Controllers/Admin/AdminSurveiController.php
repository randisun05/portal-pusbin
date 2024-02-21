<?php

namespace App\Http\Controllers\Admin;

use App\Models\Survei;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SurveiGroup;
use App\Models\SurveiIndikator;
use Illuminate\Support\Facades\Storage;

class AdminSurveiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.survei.index', [
            'datas' => Survei::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.survei.create', [

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
            'type' => 'required',
           ]);

        Survei::create($validatedData);
        return redirect()->to('/admin/survei')->with('success', 'Survei Berhasil Dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            $data = Survei::find($id);
            $indikators = SurveiGroup::with('indikator')->where('survei_id', $id)->get();
            
            return view('admin.survei.show',[
                'data' => $data,
                'indikators' => $indikators
            ])->with('data_survei', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Survei::find($id);
        return view('admin.survei.edit',[
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
    public function update(Request $request, Survei $survei)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'type' => 'required',
        ]);

        Survei::where('id', $survei->id)
                ->update($validateData);

        return redirect('/admin/survei')->with('success','Survei Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        
            Survei::destroy($id);
            return redirect('/admin/survei')->with('success','Survei Berhasil Dihapus');
    }

    public function TambahIndikator(Survei $survei)
    {

        $indikator_enrolled = SurveiGroup::where('survei_id', $survei->id)->pluck('indikator_id')->all();
        
        $indikator = SurveiIndikator::whereNotIn('id', $indikator_enrolled)->get();

        return view('admin.survei.surveigroup.create', [
            'survei'          => $survei,
            'indikators'       => $indikator,
        ]);
    }

    public function StoreIndikator(Request $request, $surveiId)
    {
    // return $request;

       // Validate the form data
       $request->validate([
        'survei_id' => 'required|',
        'indikator_id' => 'required|array',
    ]);
      
       //create exam_group
       foreach($request->indikator_id as $indikator_id) {
        
        //create exam_group
        SurveiGroup::create([
            'survei_id'         => $request->survei_id,
            'indikator_id'      => $indikator_id,
        ]);
    }

        // Redirect back with success message
        return redirect('/admin/survei/' . $request->survei_id)->with('success', 'Indikator Berhasil Ditambah');
    }

      public function DeleteIndikator($id)
    {

        SurveiGroup::destroy($id);
        return back()->with('success','Indikator Berhasil Dihapus'); 

    }

}
