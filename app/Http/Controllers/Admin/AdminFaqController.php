<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminFaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.faq.index', [
            'faqs' => Faq::orderBy('urutan')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faq.create', [
            'title' => 'FAQ',
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
        $validatedData = $request->validate([
            'pertanyaan' => 'required',
            'jawaban' => 'required',
            'kategori' => 'nullable',
            'urutan' => 'nullable|integer',
        ]);

        Faq::create($validatedData);

        return redirect('/admin/faq')->with('success', 'FAQ Berhasil Dibuat');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        return view('admin.faq.edit', [
            'title' => 'FAQ',
            'faq' => $faq,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        $validatedData = $request->validate([
            'pertanyaan' => 'required',
            'jawaban' => 'required',
            'kategori' => 'nullable',
            'urutan' => 'nullable|integer',
        ]);

        $faq->update($validatedData);

        return redirect('/admin/faq')->with('success', 'FAQ Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect('/admin/faq')->with('success', 'FAQ Berhasil Dihapus');
    }
}
