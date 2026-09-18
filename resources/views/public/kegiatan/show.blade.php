@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.web.header-detail')

<main>
    <section class="section">
        <div class="container">
            <div class="row gy-4 align-items-center">
                <div class="col-lg-6" data-aos="fade-up">
                    <img class="img-fluid rounded" src="{{ asset('storage/' . $kegiatan->image) }}" alt="{{ $kegiatan->nama }}">
                </div>
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <p class="text-uppercase small fw-bold mb-2" style="color: var(--accent-color); letter-spacing: 1px;">{{ $kegiatan->jenis }}</p>
                    <h2 class="mb-3">{{ $kegiatan->nama }}</h2>
                    <div class="d-flex align-items-center mb-4 text-muted">
                        <i class="bi bi-calendar-event me-2"></i>
                        <span>{{ $kegiatan->waktu }}</span>
                    </div>
                    @if($kegiatan->deskripsi)
                        <p class="prose-content">{{ $kegiatan->deskripsi }}</p>
                    @endif
                    <a class="btn btn-primary" href="/kegiatan/{{ $kegiatan->slug }}/create">Rencana Hadir <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>
</main>

@include('layout.web.footer')
@endsection
