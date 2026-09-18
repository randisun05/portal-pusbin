<?php

namespace App\Http\Controllers\Admin;

use App\Models\PengaturanChat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPengaturanChatController extends Controller
{
    /**
     * Display the settings form.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('admin.pengaturan-chat.edit', [
            'title' => 'Pengaturan Chat AI',
            'pengaturan' => PengaturanChat::current(),
            'providers' => PengaturanChat::providers(),
            'claudeConfigured' => ! empty(config('services.anthropic.api_key')),
            'geminiConfigured' => ! empty(config('services.gemini.api_key')),
        ]);
    }

    /**
     * Update the settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'provider' => 'required|in:' . implode(',', array_keys(PengaturanChat::providers())),
        ]);

        $pengaturan = PengaturanChat::current();
        $pengaturan->fill($validatedData);
        $pengaturan->save();

        return redirect('/admin/pengaturan-chat')->with('success', 'Pengaturan Chat AI Berhasil Diupdate');
    }
}
