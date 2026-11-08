<?php

namespace App\Http\Controllers\Public;

use App\Models\Faq;
use App\Models\Jdihjfk;
use App\Models\Pengetahuan;
use App\Models\PengaturanChat;
use App\Services\AiChatService;
use App\Services\GeminiChatService;
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
     * kata kunci FAQ di sisi klien. Provider AI (Claude/Gemini) dipilih
     * lewat menu Admin > Pengaturan Chat AI.
     */
    public function ask(Request $request, AiChatService $claudeChat, GeminiChatService $geminiChat)
    {
        $request->validate(['question' => 'required|string|max:500']);

        $service = PengaturanChat::current()->provider === PengaturanChat::PROVIDER_GEMINI
            ? $geminiChat
            : $claudeChat;

        $answer = $service->answer(
            $request->input('question'),
            Faq::select('pertanyaan', 'jawaban')->get(),
            Jdihjfk::select('title', 'deskripsi')->get(),
            Pengetahuan::active()->get(['judul', 'isi', 'kata_kunci'])
        );

        return response()->json(['answer' => $answer]);
    }
}
