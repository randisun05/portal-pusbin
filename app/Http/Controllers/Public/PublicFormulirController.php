<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Concerns\GuardsAgainstSpam;
use App\Http\Controllers\Controller;
use App\Models\Formulir;
use Illuminate\Http\Request;

class PublicFormulirController extends Controller
{
    use GuardsAgainstSpam;

    public function index()
    {
        return view('public.formulir.index', [
            'title' => 'Formulir',
            'formulirs' => Formulir::where('status', '1')->latest()->paginate(9),
        ]);
    }

    public function create(Formulir $formulir)
    {
        abort_unless($formulir->status === '1', 404);

        return view('public.formulir.create', [
            'title' => $formulir->judul,
            'formulir' => $formulir,
        ]);
    }

    public function store(Request $request, Formulir $formulir)
    {
        abort_unless($formulir->status === '1', 404);

        $rules = [];
        foreach ($formulir->fields as $field) {
            $wajib = $field->wajib ? 'required' : 'nullable';

            if ($field->tipe === 'file') {
                $rules["lampiran.{$field->id}"] = "{$wajib}|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120";
                continue;
            }

            $key = "data.{$field->id}";

            $rules[$key] = match ($field->tipe) {
                'email' => "{$wajib}|email",
                'number' => "{$wajib}|numeric",
                'date' => "{$wajib}|date",
                'rating' => "{$wajib}|integer|min:1|max:5",
                'checkbox' => "{$wajib}|array",
                'select', 'radio' => "{$wajib}|in:" . implode(',', $field->opsiList()),
                default => "{$wajib}|string|max:2000",
            };
        }

        $request->validate($rules);

        if ($this->isSpamSubmission($request)) {
            return redirect()->route('public.formulir.index')->withSuccess('Terima kasih, data Anda berhasil dikirim.');
        }

        $submission = $formulir->submissions()->create([
            'data' => $request->input('data', []),
        ]);

        foreach ($formulir->fields->where('tipe', 'file') as $field) {
            if ($request->hasFile("lampiran.{$field->id}")) {
                $submission->simpanLampiran($request->file("lampiran.{$field->id}"), 'formulir', "field:{$field->id}");
            }
        }

        return redirect()->route('public.formulir.index')->withSuccess('Terima kasih, data Anda berhasil dikirim.');
    }
}
