@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Pengaturan Chat AI</h1>
    <p class="text-center text-muted">
        Pilih provider AI yang dipakai widget chat di situs publik untuk menjawab pertanyaan
        berdasarkan Basis Pengetahuan, FAQ, dan Repository.
    </p>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8 mx-auto" role="alert">
        {{session('success')}}
        </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow" style="max-width: 700px; margin: 0 auto;">
        <div class="card-body">
            <form action="/admin/pengaturan-chat" method="POST">
                @method('put')
                @csrf

                <div class="mb-4">
                    <div class="form-check mb-3 p-3 border rounded">
                        <input class="form-check-input" type="radio" name="provider" id="provider_claude" value="claude" {{ old('provider', $pengaturan->provider) === 'claude' ? 'checked' : '' }}>
                        <label class="form-check-label w-100" for="provider_claude">
                            <strong>Claude (Anthropic)</strong>
                            @if($claudeConfigured)
                                <span class="badge bg-success ms-2">API key terkonfigurasi</span>
                            @else
                                <span class="badge bg-warning text-dark ms-2">API key belum diisi (ANTHROPIC_API_KEY)</span>
                            @endif
                        </label>
                    </div>

                    <div class="form-check p-3 border rounded">
                        <input class="form-check-input" type="radio" name="provider" id="provider_gemini" value="gemini" {{ old('provider', $pengaturan->provider) === 'gemini' ? 'checked' : '' }}>
                        <label class="form-check-label w-100" for="provider_gemini">
                            <strong>Gemini (Google)</strong>
                            @if($geminiConfigured)
                                <span class="badge bg-success ms-2">API key terkonfigurasi</span>
                            @else
                                <span class="badge bg-warning text-dark ms-2">API key belum diisi (GEMINI_API_KEY)</span>
                            @endif
                        </label>
                    </div>
                    @error('provider')
                    <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <p class="text-muted small">
                    Jika provider yang dipilih belum punya API key terkonfigurasi (lewat file .env di server),
                    chat akan otomatis jatuh kembali ke pencarian kata kunci FAQ &amp; Basis Pengetahuan biasa.
                </p>

                <div class="text-center mt-4">
                    <button class="btn btn-lg btn-primary" type="submit">Simpan Pengaturan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
