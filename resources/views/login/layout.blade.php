@extends('layout.main-main')

@push('styles')
<style>
    .login-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 32px 16px;
        background: color-mix(in srgb, var(--accent-color), #fff 94%);
    }
    .login-shell {
        width: 100%;
        max-width: 920px;
        min-height: 540px;
        display: grid;
        grid-template-columns: 5fr 6fr;
        background: var(--surface-color);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 16px 40px rgba(20, 23, 43, .12);
    }

    /* Panel brand (kiri) */
    .login-brand {
        position: relative;
        color: #fff;
        padding: 40px 36px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background: url('{{ asset('assets-flexor/img/hero-bg.jpg') }}') center / cover;
    }
    .login-brand::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(160deg, color-mix(in srgb, var(--accent-color), #000 25%) 0%, color-mix(in srgb, var(--accent-color), transparent 8%) 100%);
    }
    .login-brand > * { position: relative; }
    .login-brand .pk-logo-badge { background: #fff; color: var(--accent-color); box-shadow: none; }
    .login-brand .pk-logo-line2 { color: rgba(255, 255, 255, .8); }
    .login-brand h2 { color: #fff; font-size: 28px; font-weight: 700; line-height: 1.25; margin: 0 0 12px; }
    .login-brand p { color: rgba(255, 255, 255, .85); font-size: 15px; line-height: 1.6; margin: 0; }
    .login-brand ul { list-style: none; padding: 0; margin: 24px 0 0; font-size: 14px; }
    .login-brand ul li { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; color: rgba(255, 255, 255, .92); }
    .login-brand ul li i { font-size: 16px; }
    .login-brand .login-foot { font-size: 12px; color: rgba(255, 255, 255, .65); }

    /* Panel form (kanan) */
    .login-form-panel { padding: 48px 48px 32px; display: flex; flex-direction: column; justify-content: center; }
    .login-form-panel .login-badge {
        align-self: flex-start;
        display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600;
        padding: 4px 12px; border-radius: 50px; margin-bottom: 14px;
        background: color-mix(in srgb, var(--accent-color), transparent 88%); color: var(--accent-color);
    }
    .login-form-panel h1 { font-size: 28px; font-weight: 700; margin: 0 0 6px; }
    .login-form-panel .login-sub { color: color-mix(in srgb, var(--default-color), transparent 35%); font-size: 15px; margin-bottom: 28px; }
    .login-form-panel .form-control { padding: 11px 14px; }
    .login-form-panel .btn-login { width: 100%; padding: 12px; font-size: 16px; }
    .login-form-panel .password-wrap { position: relative; }
    .login-form-panel .password-wrap .form-control { padding-right: 46px; }
    .login-form-panel .password-toggle {
        position: absolute; top: 50%; right: 8px; transform: translateY(-50%);
        border: 0; background: none; color: #6c757d; padding: 6px 8px; cursor: pointer;
    }
    .login-form-panel .login-switch { margin: 28px 0 0; padding-top: 20px; border-top: 1px solid #eceff3; font-size: 14px; text-align: center; }
    .login-form-panel .login-switch a { color: var(--accent-color); font-weight: 600; }
    .login-form-panel .login-back { text-align: center; margin: 14px 0 0; font-size: 13px; }
    .login-form-panel .login-back a { color: color-mix(in srgb, var(--default-color), transparent 35%); }

    @media (max-width: 767.98px) {
        .login-shell { grid-template-columns: 1fr; min-height: 0; max-width: 460px; }
        .login-brand { padding: 24px; }
        .login-brand h2 { font-size: 22px; }
        .login-brand ul, .login-brand p, .login-brand .login-foot { display: none; }
        .login-form-panel { padding: 32px 24px 24px; }
    }
</style>
@endpush

@section('noChat', '1')

@section('container')
<main class="login-page">
    <div class="login-shell">
        <aside class="login-brand">
            <div>@include('layout.partial.logo', ['light' => true])</div>
            <div>
                <h2>Portal Admin<br>Direktorat JF MASN</h2>
                <p>Kelola konten, layanan, dan data portal Direktorat Jabatan Fungsional Manajemen ASN.</p>
                <ul>
                    <li><i class="bi bi-shield-lock"></i> Akses khusus admin terdaftar</li>
                    <li><i class="bi bi-phone"></i> Verifikasi dua langkah (2FA)</li>
                    <li><i class="bi bi-journal-check"></i> Setiap aktivitas tercatat</li>
                </ul>
            </div>
            <div class="login-foot">&copy; {{ date('Y') }} Direktorat JF MASN &middot; BKN</div>
        </aside>

        <section class="login-form-panel">
            @yield('badge')
            <h1>@yield('heading')</h1>
            <p class="login-sub">@yield('subheading')</p>

            @if (session('loginerror'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('loginerror') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('form')

            <p class="login-switch">@yield('switch')</p>
            <p class="login-back"><a href="/webpusbin"><i class="bi bi-arrow-left me-1"></i>Kembali ke beranda</a></p>
        </section>
    </div>
</main>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.password-toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.getElementById(btn.dataset.target);
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.querySelector('i').className = 'bi ' + (show ? 'bi-eye-slash' : 'bi-eye');
        });
    });
</script>
@endpush
