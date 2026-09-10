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
            'datas' => Jdihjfk::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.jdihjfk.create');
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
            'title' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'link' => 'nullable|url',
            'image' => 'nullable|image|file|max:1024',
            'status' => 'required|in:published,internal',
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('post-image');
        }

        Jdihjfk::create($validatedData);

        return redirect()->to('/admin/repository')->with('success', 'Dokumen repository berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Jdihjfk $repository)
    {
        return redirect("/admin/repository/{$repository->id}/edit");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Jdihjfk $repository)
    {
        return view('admin.jdihjfk.edit', [
            'data' => $repository,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jdihjfk $repository)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'link' => 'nullable|url',
            'image' => 'nullable|image|file|max:1024',
            'status' => 'required|in:published,internal',
        ]);

        if ($request->hasFile('image')) {
            if ($repository->image) {
                Storage::delete($repository->image);
            }
            $validatedData['image'] = $request->file('image')->store('post-image');
        }

        $repository->update($validatedData);

        return redirect('/admin/repository')->with('success', 'Dokumen repository berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jdihjfk $repository)
    {
        if ($repository->image) {
            Storage::delete($repository->image);
        }

        $repository->delete();

        return redirect('/admin/repository')->with('success', 'Dokumen repository berhasil dihapus');
    }
}
