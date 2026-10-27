@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
<main>

@include('layout.web.header-detail')

    <!-- Direktur Section -->
    <section class="section">
        <div class="container">
            @if($kapus)
                <div class="row gy-4 align-items-center">
                    <div class="col-lg-4" data-aos="fade-up">
                        @if($kapus->foto)
                            <img class="img-fluid rounded" src="{{ asset('storage/' . $kapus->foto) }}" alt="{{ $kapus->nama }}">
                        @else
                            <div class="w-100 d-flex align-items-center justify-content-center bg-light rounded" style="min-height: 320px;">
                                <span class="display-4 fw-bold text-secondary">{{ strtoupper(substr($kapus->nama, 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-7 offset-lg-1" data-aos="fade-up" data-aos-delay="100">
                        <h3 class="mb-1">{{ $kapus->nama }}</h3>
                        <span class="d-block mb-3" style="color: var(--accent-color); font-weight: 600;">{{ $kapus->jabatan }}</span>
                        @if($kapus->deskripsi)
                            <p class="prose-content">{{ $kapus->deskripsi }}</p>
                        @endif
                        <ul class="list-unstyled mt-3">
                            @if($kapus->email)
                                <li class="mb-2"><i class="bi bi-envelope me-2"></i><b>Email:</b> <a href="mailto:{{ $kapus->email }}">{{ $kapus->email }}</a></li>
                            @endif
                            @if($kapus->telepon)
                                <li class="mb-2"><i class="bi bi-telephone me-2"></i><b>Telepon:</b> <a href="tel:{{ $kapus->telepon }}">{{ $kapus->telepon }}</a></li>
                            @endif
                            <li><i class="bi bi-diagram-3 me-2"></i><b>Struktur Organisasi:</b> <a href="/about/struktur-organisasi">Lihat Bagan Lengkap</a></li>
                        </ul>
                    </div>
                </div>
            @else
                <p class="text-center text-muted">Data Direktur belum tersedia. Silakan tambahkan melalui menu admin &raquo; Struktur Organisasi.</p>
            @endif
        </div>
    </section><!-- /Direktur Section -->
</main>


@include('layout.web.footer')

@endsection
