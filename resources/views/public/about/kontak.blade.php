@extends('layout.main-main')
@section('container')
@include('layout.web.nav')

<main>
@include('layout.web.header-detail')

    <style>
        .kk-info-card { display: flex; gap: 14px; align-items: flex-start; background: var(--surface-color); border: 1px solid color-mix(in srgb, var(--default-color), transparent 90%); border-radius: 14px; padding: 20px; margin-bottom: 16px; }
        .kk-info-icon { flex: 0 0 auto; width: 44px; height: 44px; border-radius: 50%; background: color-mix(in srgb, var(--accent-color), transparent 90%); color: var(--accent-color); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
        .kk-info-card h6 { margin-bottom: 4px; }
        .kk-info-card p { margin: 0; color: var(--default-color); font-size: .92rem; }
        .kk-map iframe { width: 100%; height: 260px; border: 0; border-radius: 14px; }
        .kk-form .form-control { border-radius: 8px; }
        .kk-social a { display: inline-flex; width: 38px; height: 38px; border-radius: 50%; background: color-mix(in srgb, var(--accent-color), transparent 90%); color: var(--accent-color); align-items: center; justify-content: center; margin-right: 8px; }
    </style>

    <section class="section">
        <div class="container">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row g-5">
                <div class="col-lg-5" data-aos="fade-up">
                    <h3 class="mb-4">Informasi Kontak</h3>

                    <div class="kk-info-card">
                        <div class="kk-info-icon"><i class="bi bi-geo-alt"></i></div>
                        <div>
                            <h6>Alamat</h6>
                            <p>{{ $profil->alamat ?? 'Jl. Mayjen Sutoyo No. 12, Jakarta Timur, 13640 – Indonesia' }}</p>
                        </div>
                    </div>

                    <div class="kk-info-card">
                        <div class="kk-info-icon"><i class="bi bi-telephone"></i></div>
                        <div>
                            <h6>Telepon</h6>
                            <p>{{ $profil->telepon ?? '021-8093008' }}</p>
                        </div>
                    </div>

                    <div class="kk-info-card">
                        <div class="kk-info-icon"><i class="bi bi-envelope"></i></div>
                        <div>
                            <h6>Email</h6>
                            <p>{{ $profil->email ?? 'pusbinjfk@gmail.com' }}</p>
                        </div>
                    </div>

                    <div class="kk-info-card">
                        <div class="kk-info-icon"><i class="bi bi-clock"></i></div>
                        <div>
                            <h6>Jam Operasional</h6>
                            <p>{{ $profil->jam_operasional ?? 'Senin - Jumat, 08.00 - 16.00 WIB' }}</p>
                        </div>
                    </div>

                    @if($profil->maps_embed)
                        <div class="kk-map mt-4">
                            <iframe src="{{ $profil->maps_embed }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    @endif

                    @if($profil->instagram || $profil->facebook || $profil->youtube || $profil->twitter)
                        <div class="kk-social mt-4">
                            @if($profil->instagram)<a href="{{ $profil->instagram }}" target="_blank"><i class="bi bi-instagram"></i></a>@endif
                            @if($profil->facebook)<a href="{{ $profil->facebook }}" target="_blank"><i class="bi bi-facebook"></i></a>@endif
                            @if($profil->youtube)<a href="{{ $profil->youtube }}" target="_blank"><i class="bi bi-youtube"></i></a>@endif
                            @if($profil->twitter)<a href="{{ $profil->twitter }}" target="_blank"><i class="bi bi-twitter-x"></i></a>@endif
                        </div>
                    @endif
                </div>

                <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="mb-4">Kirim Pesan</h3>
                    <form class="kk-form" action="/about/kontak-kami" method="POST">
                        @csrf
                        @include('layout.partial.honeypot')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" value="{{ old('nama') }}" required>
                                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="telepon" class="form-label">Telepon (opsional)</label>
                                <input type="text" class="form-control @error('telepon') is-invalid @enderror" name="telepon" id="telepon" value="{{ old('telepon') }}">
                                @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="subjek" class="form-label">Subjek</label>
                                <input type="text" class="form-control @error('subjek') is-invalid @enderror" name="subjek" id="subjek" value="{{ old('subjek') }}">
                                @error('subjek')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="pesan" class="form-label">Pesan</label>
                                <textarea class="form-control @error('pesan') is-invalid @enderror" name="pesan" id="pesan" rows="5" required>{{ old('pesan') }}</textarea>
                                @error('pesan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Kirim Pesan <i class="bi bi-send"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@include('layout.web.footer')
@endsection
