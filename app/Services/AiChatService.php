<?php

namespace App\Services;

use Anthropic\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class AiChatService
{
    /**
     * Jawab pertanyaan pengunjung memakai Claude, dibekali daftar FAQ dan
     * dokumen Repository (baik yang dipublikasikan maupun yang internal)
     * sebagai konteks pengetahuan. Mengembalikan null jika API key belum
     * dikonfigurasi atau pemanggilan gagal, sehingga pemanggil bisa jatuh
     * kembali ke pencarian kata kunci FAQ biasa.
     */
    public function answer(string $question, Collection $faqs, ?Collection $repository = null): ?string
    {
        $apiKey = config('services.anthropic.api_key');

        if (empty($apiKey)) {
            return null;
        }

        $faqContext = $faqs->map(function ($faq) {
            return "Q: {$faq->pertanyaan}\nA: {$faq->jawaban}";
        })->implode("\n\n");

        $repositoryContext = ($repository ?? collect())->map(function ($doc) {
            return "Judul: {$doc->title}\nIsi: {$doc->deskripsi}";
        })->implode("\n\n");

        $systemPrompt = "Anda adalah asisten virtual Direktorat Jabatan Fungsional Manajemen Aparatur Sipil Negara (Direktorat JF MASN), Badan Kepegawaian Negara. "
            . "Jawab pertanyaan pengunjung website secara singkat, sopan, dan dalam Bahasa Indonesia, "
            . "berdasarkan daftar FAQ dan dokumen Repository berikut. Jika pertanyaan tidak tercakup dalam sumber tersebut, arahkan pengunjung "
            . "untuk menghubungi kami melalui halaman Kontak.\n\nDaftar FAQ:\n{$faqContext}\n\nDokumen Repository:\n{$repositoryContext}";

        try {
            $client = new Client(apiKey: $apiKey);

            $message = $client->messages->create(
                model: 'claude-opus-5',
                maxTokens: 512,
                system: $systemPrompt,
                messages: [
                    ['role' => 'user', 'content' => $question],
                ],
            );

            foreach ($message->content as $block) {
                if ($block->type === 'text') {
                    return $block->text;
                }
            }

            return null;
        } catch (\Throwable $e) {
            Log::warning('AiChatService: gagal memanggil Claude API.', ['error' => $e->getMessage()]);

            return null;
        }
    }
}
