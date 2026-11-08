@extends('layout.main-main')

@section('bodyClass', 'index-page')

@section('container')

<!-- Navbar  -->
@include('layout.web.nav')
<main class="main">
    @include('layout.web.header')
    @include('layout.web.data')
    @include('layout.web.show')
    @include('layout.web.fungsi')
    @include('layout.web.layanan')
    @include('layout.web.kegiatan')
    @include('layout.web.berita')
    @include('layout.web.peraturan')

    <!-- FAQ Section -->
    <section id="faq" class="faq section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Pertanyaan yang Sering Diajukan</h2>
            <p>Belum menemukan jawaban? Ajukan pertanyaan Anda langsung ke tim kami</p>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="faq-container">
                        @forelse ($faqs as $faq)
                            <div class="faq-item {{ $loop->first ? 'faq-active' : '' }}" data-aos="fade-up" data-aos-delay="{{ 100 * ($loop->index + 1) }}">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>{{ $faq->pertanyaan }}</h3>
                                <div class="faq-content">
                                    <p>{{ $faq->jawaban }}</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div>
                        @empty
                            <p class="text-center text-muted">Belum ada pertanyaan yang tersedia.</p>
                        @endforelse
                    </div>
                    <div class="text-center mt-4">
                        <a href="/faq" class="more-btn"><span>Lihat Semua FAQ</span> <i class="bi bi-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /FAQ Section -->
</main>
@include('layout.web.footer')

@endsection
