<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jdihjfk;

class JdihjfkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $jdihs = Jdihjfk::latest()->filter(request(['search']))->paginate(6);
        // return $jdihs;

        

        return view('jdihjfk.index', [
            "title" => "JDIH JFK",
            "jdihs" => Jdihjfk::latest()->filter(request(['search']))->paginate(6)

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function show(Jdihjfk $jdih)
    {

        return view('jdihjfk.show', [
            "title" => "Peraturan Terkait JFK",
            "jdih" => $jdih

        ]);
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
