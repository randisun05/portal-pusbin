<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LayananHalaman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminLayananHalamanController extends Controller
{
    public function index()
    {
        return view('admin.layanan-halaman.index', [
            'halamans' => LayananHalaman::orderBy('urutan')->orderBy('id')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.layanan-halaman.create', [
            'nextUrutan' => (LayananHalaman::max('urutan') ?? 0) + 1,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        LayananHalaman::create($data);

        return redirect('/admin/layanan-halaman')->with('success', 'Halaman layanan berhasil dibuat');
    }

    public function edit(LayananHalaman $layananHalaman)
    {
        return view('admin.layanan-halaman.edit', ['halaman' => $layananHalaman]);
    }

    public function update(Request $request, LayananHalaman $layananHalaman)
    {
        $layananHalaman->update($this->validated($request, $layananHalaman));

        return redirect('/admin/layanan-halaman')->with('success', 'Halaman layanan berhasil diperbarui');
    }

    public function destroy(LayananHalaman $layananHalaman)
    {
        $layananHalaman->delete();

        return redirect('/admin/layanan-halaman')->with('success', 'Halaman layanan berhasil dihapus');
    }

    private function validated(Request $request, ?LayananHalaman $current = null): array
    {
        $request->merge(['slug' => Str::slug($request->input('slug') ?: $request->input('nama'))]);

        $data = $request->validate([
            'nama' => 'required|max:255',
            'slug' => ['required', 'max:255', Rule::unique('layanan_halamans', 'slug')->ignore($current?->id)],
            'judul' => 'required|max:255',
            'konten' => 'nullable',
            'urutan' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
        ]);

        return $data;
    }
}
