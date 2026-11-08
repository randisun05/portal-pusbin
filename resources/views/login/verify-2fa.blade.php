@extends('login.layout')

@section('badge')
    <span class="login-badge"><i class="bi bi-shield-lock"></i> Verifikasi 2FA</span>
@endsection

@section('heading', 'Verifikasi Dua Langkah')
@section('subheading', 'Masukkan kode 6 digit dari aplikasi authenticator Anda, atau salah satu recovery code jika kode tidak tersedia.')

@section('form')
<form action="/login/verifikasi-2fa" method="post">
    @csrf
    <div class="mb-4">
        <label for="code" class="form-label">Kode Verifikasi</label>
        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" placeholder="123456" required autofocus autocomplete="one-time-code">
        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <button type="submit" class="btn btn-primary btn-login">Verifikasi</button>
</form>
@endsection

@section('switch')
    <a href="/login"><i class="bi bi-arrow-left"></i> Kembali ke halaman login</a>
@endsection
