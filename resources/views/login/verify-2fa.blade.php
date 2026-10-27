@extends('layout.main-main')
@section('container')

<main>
    <div class="login-area mt-25 pb-30">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6">
                    <div class="tp-login-wrapper">
                        <h3 class="tp-login-title">Verifikasi Dua Langkah</h3>
                        <p class="text-muted">Masukkan kode 6 digit dari aplikasi authenticator Anda, atau salah satu recovery code jika kode tidak tersedia.</p>

                        @if (session('loginerror'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fa fa-exclamation-circle me-2"></i>{{ session('loginerror') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="tp-login-form">
                            <form action="/login/verifikasi-2fa" method="post">
                                @csrf
                                <div class="tp-login-input">
                                    <div class="tp-login-input-item mb-25">
                                        <label for="code">Kode Verifikasi</label>
                                        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" placeholder="123456" autofocus autocomplete="one-time-code">
                                        @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="tp-login-btn">
                                    <button type="submit" class="tp-btn w-100">Verifikasi</button>
                                </div>
                            </form>
                            <div class="text-center mt-3">
                                <a href="/login">Kembali ke halaman login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
