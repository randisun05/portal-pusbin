@extends('login.layout')

@section('badge')
    <span class="login-badge"><i class="bi bi-shield-check"></i> SSO SIASN</span>
@endsection

@section('heading', 'Login MyASN')
@section('subheading', 'Masuk menggunakan akun MyASN (SSO SIASN) Anda. Kredensial dimasukkan langsung di halaman resmi BKN.')

@section('form')
@unless ($siasnEnabled)
    <div class="alert alert-warning" role="alert">
        <i class="bi bi-info-circle me-2"></i>Login MyASN belum diaktifkan di portal ini. Gunakan login manual.
    </div>
@endunless

@if ($siasnEnabled)
    <a href="/login/sso/redirect" class="btn btn-primary btn-login"><i class="bi bi-box-arrow-in-right me-2"></i>Login MyASN</a>
@else
    <button type="button" class="btn btn-primary btn-login" disabled><i class="bi bi-box-arrow-in-right me-2"></i>Login MyASN</button>
@endif
<p class="text-muted small text-center mt-3 mb-0">NIP Anda harus sudah ditautkan ke akun admin oleh Super Admin.</p>
@endsection

@section('switch')
    Punya akun admin lokal? <a href="/login">Login manual <i class="bi bi-arrow-right"></i></a>
@endsection
