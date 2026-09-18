@extends('layout.main-admin')

@section('container')

<div class="container-fluid">

    <h1 class="h3 mb-2 mt-5 text-center">Autentikasi Dua Faktor (2FA)</h1>
    <p class="text-center text-muted">
        Tambahkan lapisan keamanan ekstra ke akun Anda. Setelah aktif, login akan meminta kode dari
        aplikasi authenticator (Google Authenticator, Authy, dsb) selain email &amp; password.
    </p>

    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8 mx-auto" role="alert">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger col-lg-8 mx-auto" role="alert">{{ session('error') }}</div>
    @endif
    @if (session()->has('info'))
        <div class="alert alert-info col-lg-8 mx-auto" role="alert">{{ session('info') }}</div>
    @endif

    @if ($recoveryCodes)
        <div class="card shadow mb-4" style="max-width: 700px; margin: 0 auto;">
            <div class="card-body">
                <h5 class="text-danger">Simpan Recovery Code Anda</h5>
                <p class="text-muted small">
                    Kode ini hanya ditampilkan SEKALI. Simpan di tempat aman - dipakai untuk login jika Anda
                    kehilangan akses ke aplikasi authenticator. Setiap kode hanya bisa dipakai satu kali.
                </p>
                <div class="row row-cols-2 g-2 font-monospace">
                    @foreach ($recoveryCodes as $rc)
                        <div class="col"><span class="badge bg-light text-dark border">{{ $rc }}</span></div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="card shadow" style="max-width: 700px; margin: 0 auto;">
        <div class="card-body">

            @if ($user->hasTwoFactorEnabled())
                <div class="d-flex align-items-center mb-4">
                    <span class="badge bg-success me-2">Aktif</span>
                    <span>2FA aktif sejak {{ $user->two_factor_enabled_at->translatedFormat('d F Y, H:i') }}.</span>
                </div>

                <hr>
                <h6>Nonaktifkan 2FA</h6>
                <form action="/admin/two-factor/disable" method="POST" class="row g-2 align-items-end">
                    @csrf
                    <div class="col-md-6">
                        <label for="password" class="form-label">Konfirmasi Password Anda</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menonaktifkan 2FA?')">Nonaktifkan 2FA</button>
                    </div>
                </form>

            @elseif ($pendingSecret)
                <div class="text-center mb-3">
                    <img src="{{ $qrCodeDataUri }}" alt="QR Code 2FA" class="img-fluid" style="max-width: 220px;">
                </div>
                <p class="text-muted small text-center">
                    Pindai QR di atas dengan aplikasi authenticator, lalu masukkan kode 6 digit yang muncul untuk konfirmasi.
                </p>
                <p class="text-center small">
                    Tidak bisa pindai? Masukkan manual: <code>{{ $pendingSecret }}</code>
                </p>
                <form action="/admin/two-factor/confirm" method="POST" class="row g-2 justify-content-center">
                    @csrf
                    <div class="col-md-4">
                        <input type="text" class="form-control text-center @error('code') is-invalid @enderror" name="code" placeholder="123456" maxlength="6" autofocus required>
                        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">Konfirmasi &amp; Aktifkan</button>
                    </div>
                </form>

            @else
                <div class="d-flex align-items-center mb-4">
                    <span class="badge bg-secondary me-2">Non Aktif</span>
                    <span>Akun Anda belum menggunakan autentikasi dua faktor.</span>
                </div>
                <form action="/admin/two-factor/enable" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Aktifkan 2FA</button>
                </form>
            @endif

        </div>
    </div>
</div>

@endsection
