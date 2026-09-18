@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.web.header-detail')

<main>
    <section class="section">
    <div class="container">
        @if ($kegiatans->count())
        <div class="row gy-4">
            @foreach ($kegiatans as $kegiatan)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 * (($loop->index % 6) + 1) }}">
                <article>
                    <div class="post-img">
                        <img src="{{ asset('storage/' . $kegiatan->image) }}" alt="{{ $kegiatan->nama }}" class="img-fluid">
                    </div>
                    <h2 class="title"><a href="/absensi/{{ $kegiatan->slug }}">{{ $kegiatan->nama }}</a></h2>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar-event flex-shrink-0 me-2"></i>
                        <div class="post-meta">
                            <p class="post-date mb-0">{{ $kegiatan->waktu }}</p>
                        </div>
                    </div>
                    @if ($kegiatan->isPresensiTertutup())
                        <span class="badge bg-secondary mt-2">Presensi Ditutup</span>
                    @else
                        <a href="/absensi/{{ $kegiatan->slug }}" class="more-btn mt-2"><span>Daftar</span> <i class="bi bi-chevron-right"></i></a>
                    @endif
                </article>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $kegiatans->links() }}
        </div>
        @else
        <p class="text-center fs-4 text-muted">Belum ada kegiatan ditemukan.</p>
        @endif
    </div>
    </section>
</main>

@include('layout.web.footer')
@endsection
