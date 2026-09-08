<?php

namespace App\Http\Controllers\Public;

use App\Models\Faq;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    public function index()
    {
        return view('public.faq.index', [
            'title' => 'Pertanyaan yang Sering Diajukan',
            'faqs' => Faq::orderBy('urutan')->get()->groupBy(fn ($faq) => $faq->kategori ?? 'Umum'),
        ]);
    }
}
