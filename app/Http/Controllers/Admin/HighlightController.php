<?php

namespace App\Http\Controllers\Admin;

use App\Models\highlight;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class HighlightController extends Controller
{
    /**
     * Display a listing of the resource, dikelompokkan per bagian beranda.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $activeGroup = $request->get('group', highlight::GROUP_HERO);

        if (! array_key_exists($activeGroup, highlight::groups())) {
            $activeGroup = highlight::GROUP_HERO;
        }

        return view('admin.highlight.index', [
            'highlights' => highlight::group($activeGroup)->get(),
            'groups' => highlight::groups(),
            'activeGroup' => $activeGroup,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $activeGroup = $request->get('group', highlight::GROUP_HERO);

        return view('admin.highlight.create', [
            'title' => 'Highlight',
            'groups' => highlight::groups(),
            'activeGroup' => $activeGroup,
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
            'group' => 'required|in:' . implode(',', array_keys(highlight::groups())),
            'name' => 'required',
            'desc' => 'required',
            'icon' => 'nullable|string',
            'link' => 'nullable|string',
            'image' => 'nullable|image|file|max:1024',
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('post-image');
        }

        $validatedData['urutan'] = highlight::group($validatedData['group'])->count();

        highlight::create($validatedData);

        return redirect()->to('/admin/highlight?group=' . $validatedData['group'])->with('success', 'Highlight Berhasil Dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        {

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(highlight $highlight)
    {
        return view('admin.highlight.edit',[
            'highlight' => $highlight,
            'groups' => highlight::groups(),
           ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, highlight $highlight)
    {
        $validateData = $request->validate([
            'group' => 'required|in:' . implode(',', array_keys(highlight::groups())),
            'name' => 'required',
            'desc' => 'required',
            'icon' => 'nullable|string',
            'link' => 'nullable|string',
            'image' => 'nullable|image|file|max:1024',
        ]);

        if ($request->file('image')) {
            if ($highlight->image) {
                Storage::delete($highlight->image);
            }
            $validateData['image'] = $request->file('image')->store('post-image');
        }

        $highlight->update($validateData);

        return redirect('/admin/highlight?group=' . $validateData['group'])->with('success','Highlight Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(highlight $highlight)
    {
        if($highlight->image){
            Storage::delete($highlight->image);
        }
        $group = $highlight->group;
        highlight::destroy($highlight->id);
        return redirect('/admin/highlight?group=' . $group)->with('success','Highlight Berhasil Dihapus');
    }
}
