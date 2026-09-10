<?php

namespace App\Http\Controllers\Public;

use App\Models\Faq;
use App\Models\Jdihjfk;
use App\Services\AiChatService;
use Illuminate\Http\Request;
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

    /**
     * Endpoint chat widget: coba jawab dengan AI (jika API key tersedia),
     * jika tidak dikembalikan null agar widget jatuh kembali ke pencarian
     * kata kunci FAQ di sisi klien.
     */
    public function ask(Request $request, AiChatService $aiChat)
    {
        $request->validate(['question' => 'required|string|max:500']);

        $answer = $aiChat->answer(
            $request->input('question'),
            Faq::select('pertanyaan', 'jawaban')->get(),
            Jdihjfk::select('title', 'deskripsi')->get()
        );

        return response()->json(['answer' => $answer]);
    }
}
