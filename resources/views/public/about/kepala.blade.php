@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
<main>

@include('layout.web.header-detail')

    <!-- team-details-area-start -->
    <div class="team-details-area pt-120 mb-55">
        <div class="container">
            @if($kapus)
                <div class="row gx-0">
                    <div class="offset-xl-1 col-xl-4 col-lg-5 h-100">
                        <div class="tp-team-details-thumb tp-thumb">
                            <div class="tp-thumb-overlay wow"></div>
                            @if($kapus->foto)
                                <img class="w-100" src="{{ asset('storage/' . $kapus->foto) }}" alt="{{ $kapus->nama }}">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light" style="min-height: 320px;">
                                    <span class="display-4 fw-bold text-secondary">{{ strtoupper(substr($kapus->nama, 0, 1)) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="tp-team-details-content h-100">
                            <h3 class="tp-team-details-title">{{ $kapus->nama }}</h3>
                            <span class="tp-team-details-subtitle">{{ $kapus->jabatan }}</span>
                            @if($kapus->deskripsi)
                                <p>{{ $kapus->deskripsi }}</p>
                            @endif
                            <div class="tp-team-details-list">
                                @if($kapus->email)
                                    <p><b>Email:</b><a href="mailto:{{ $kapus->email }}">{{ $kapus->email }}</a></p>
                                @endif
                                @if($kapus->telepon)
                                    <p><b>Telepon:</b><a href="tel:{{ $kapus->telepon }}">{{ $kapus->telepon }}</a></p>
                                @endif
                                <p><b>Struktur Organisasi:</b><a href="/about/struktur-organisasi">Lihat Bagan Lengkap</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-center text-muted">Data Kepala Pusat belum tersedia. Silakan tambahkan melalui menu admin &raquo; Struktur Organisasi.</p>
            @endif
        </div>
    </div>
    <!-- team-details-area-end -->
</main>


@include('layout.web.footer')

@endsection
