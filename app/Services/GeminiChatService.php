<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiChatService
{
    /**
     * Jawab pertanyaan pengunjung memakai Google Gemini, dibekali Basis
     * Pengetahuan, FAQ, dan dokumen Repository sebagai konteks. Struktur
     * dan perilaku method ini sengaja dibuat identik dengan
     * AiChatService::answer() supaya FaqController bisa menukar provider
     * tanpa mengubah cara pemanggilannya. Mengembalikan null jika API key
     * belum dikonfigurasi atau pemanggilan gagal.
     */
    public function answer(string $question, Collection $faqs, ?Collection $repository = null, ?Collection $knowledge = null): ?string
    {
        $apiKey = config('services.gemini.api_key');

        if (empty($apiKey)) {
            return null;
        }

        $faqContext = $faqs->map(function ($faq) {
            return "Q: {$faq->pertanyaan}\nA: {$faq->jawaban}";
        })->implode("\n\n");

        $repositoryContext = ($repository ?? collect())->map(function ($doc) {
            return "Judul: {$doc->title}\nIsi: {$doc->deskripsi}";
        })->implode("\n\n");

        $knowledgeContext = ($knowledge ?? collect())->map(function ($item) {
            $kataKunci = $item->kata_kunci ? " (Kata kunci: {$item->kata_kunci})" : '';

            return "Judul: {$item->judul}{$kataKunci}\nIsi: {$item->isi}";
        })->implode("\n\n");

        $systemPrompt = "Anda adalah asisten virtual Direktorat Jabatan Fungsional Manajemen Aparatur Sipil Negara (Direktorat JF MASN), Badan Kepegawaian Negara. "
            . "Jawab pertanyaan pengunjung website secara singkat, sopan, dan dalam Bahasa Indonesia, "
            . "berdasarkan Basis Pengetahuan, daftar FAQ, dan dokumen Repository berikut. Jika pertanyaan tidak tercakup dalam sumber tersebut, arahkan pengunjung "
            . "untuk menghubungi kami melalui halaman Kontak.\n\nBasis Pengetahuan:\n{$knowledgeContext}\n\nDaftar FAQ:\n{$faqContext}\n\nDokumen Repository:\n{$repositoryContext}";

        $model = config('services.gemini.model', 'gemini-2.0-flash');

        try {
            $response = Http::timeout(15)->post(
                "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}",
                [
                    'systemInstruction' => [
                        'parts' => [['text' => $systemPrompt]],
                    ],
                    'contents' => [
                        ['role' => 'user', 'parts' => [['text' => $question]]],
                    ],
                    'generationConfig' => [
                        'maxOutputTokens' => 512,
                    ],
                ]
            );

            if (! $response->successful()) {
                Log::warning('GeminiChatService: respons gagal dari Gemini API.', ['status' => $response->status(), 'body' => $response->body()]);

                return null;
            }

            return data_get($response->json(), 'candidates.0.content.parts.0.text');
        } catch (\Throwable $e) {
            Log::warning('GeminiChatService: gagal memanggil Gemini API.', ['error' => $e->getMessage()]);

            return null;
        }
    }
}
