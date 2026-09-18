@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.web.header-detail')

<main>
    <section class="section">
        <div class="container">
            <div class="row gy-4 align-items-center">
                <div class="col-lg-6" data-aos="fade-up">
                    @if($kegiatan->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($kegiatan->image))
                        <img class="img-fluid rounded" src="{{ asset('storage/' . $kegiatan->image) }}" alt="{{ $kegiatan->nama }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light rounded" style="height: 320px;">
                            <i class="bi bi-calendar-event fs-1 text-muted"></i>
                        </div>
                    @endif
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

            @if($kegiatan->materis->isNotEmpty())
                <div class="row mt-5" data-aos="fade-up">
                    <div class="col-12">
                        <h4 class="mb-3"><i class="bi bi-file-earmark-arrow-down me-2"></i>Materi Paparan</h4>
                        <div class="list-group">
                            @foreach ($kegiatan->materis as $materi)
                                <a href="/storage/{{ $materi->file }}" download="{{ $materi->judul }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="bi bi-file-earmark-text me-2" style="color: var(--accent-color);"></i>
                                        {{ $materi->judul }}
                                        @if($materi->keterangan)
                                            <span class="text-muted small d-block ms-4">{{ $materi->keterangan }}</span>
                                        @endif
                                    </span>
                                    <span class="badge bg-light text-dark border"><i class="bi bi-download me-1"></i>Unduh</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</main>

@include('layout.web.footer')
@endsection
