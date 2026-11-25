<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FormulirSubmissionExport;
use App\Http\Controllers\Controller;
use App\Models\Formulir;
use App\Models\FormulirField;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class AdminFormulirController extends Controller
{
    public function index()
    {
        return view('admin.formulir.index', [
            'formulirs' => Formulir::withCount(['fields', 'submissions'])->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.formulir.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'status' => 'required|in:0,1',
        ]);

        $slug = Str::slug($validated['judul']);
        $original = $slug;
        $i = 1;
        while (Formulir::where('slug', $slug)->exists()) {
            $slug = $original . '-' . (++$i);
        }
        $validated['slug'] = $slug;

        $formulir = Formulir::create($validated);

        return redirect("/admin/formulir/{$formulir->id}/field")->with('success', 'Formulir berhasil dibuat, sekarang tambahkan field.');
    }

    public function edit(Formulir $formulir)
    {
        return view('admin.formulir.edit', [
            'data' => $formulir,
        ]);
    }

    public function update(Request $request, Formulir $formulir)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'status' => 'required|in:0,1',
        ]);

        $formulir->update($validated);

        return redirect('/admin/formulir')->with('success', 'Formulir berhasil diupdate.');
    }

    public function destroy(Formulir $formulir)
    {
        $formulir->delete();

        return redirect('/admin/formulir')->with('success', 'Formulir berhasil dihapus.');
    }

    public function fieldIndex(Formulir $formulir)
    {
        return view('admin.formulir.field', [
            'formulir' => $formulir,
            'fields' => $formulir->fields,
            'tipeList' => FormulirField::TIPE_LIST,
            'tipeBerOpsi' => FormulirField::TIPE_BEROPSI,
        ]);
    }

    public function fieldStore(Request $request, Formulir $formulir)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'tipe' => 'required|in:' . implode(',', array_keys(FormulirField::TIPE_LIST)),
            'opsi' => 'nullable|string',
            'wajib' => 'nullable|boolean',
        ]);

        $opsi = null;
        if (in_array($validated['tipe'], FormulirField::TIPE_BEROPSI, true)) {
            $opsi = collect(explode("\n", $validated['opsi'] ?? ''))
                ->map(fn ($item) => trim($item))
                ->filter()
                ->values()
                ->all();
        }

        $formulir->fields()->create([
            'label' => $validated['label'],
            'tipe' => $validated['tipe'],
            'opsi' => $opsi,
            'wajib' => $request->boolean('wajib'),
            'urutan' => $formulir->fields()->count(),
        ]);

        return redirect("/admin/formulir/{$formulir->id}/field")->with('success', 'Field berhasil ditambah.');
    }

    public function fieldDestroy(Formulir $formulir, FormulirField $field)
    {
        if ($field->formulir_id !== $formulir->id) {
            abort(404);
        }

        $field->delete();

        return back()->with('success', 'Field berhasil dihapus.');
    }

    public function fieldNaik(Formulir $formulir, FormulirField $field)
    {
        $this->tukarUrutan($formulir, $field, -1);

        return back()->with('success', 'Urutan field diubah.');
    }

    public function fieldTurun(Formulir $formulir, FormulirField $field)
    {
        $this->tukarUrutan($formulir, $field, 1);

        return back()->with('success', 'Urutan field diubah.');
    }

    protected function tukarUrutan(Formulir $formulir, FormulirField $field, int $arah): void
    {
        if ($field->formulir_id !== $formulir->id) {
            abort(404);
        }

        $tetangga = $formulir->fields()
            ->where('urutan', $field->urutan + $arah)
            ->first();

        if (! $tetangga) {
            return;
        }

        $urutanField = $field->urutan;
        $field->update(['urutan' => $tetangga->urutan]);
        $tetangga->update(['urutan' => $urutanField]);
    }

    public function submissions(Formulir $formulir)
    {
        return view('admin.formulir.submissions', [
            'formulir' => $formulir,
            'fields' => $formulir->fields,
            'submissions' => $formulir->submissions()->with('lampirans')->latest()->paginate(20),
        ]);
    }

    public function export(Formulir $formulir)
    {
        $namaFile = Str::slug($formulir->judul) . '-submission.xlsx';

        return Excel::download(new FormulirSubmissionExport($formulir), $namaFile);
    }
}
