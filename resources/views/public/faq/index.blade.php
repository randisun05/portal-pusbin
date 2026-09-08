@extends('layout.main-main')
@section('container')
@include('layout.web.nav')

<main>
@include('layout.web.header-detail')

    <style>
        .faq-accordion .accordion-button:not(.collapsed) { background: #fdeceb; color: #f92c24; }
        .faq-category { margin-bottom: 24px; }
    </style>

    <div class="container py-5 px-lg-5">
        @if($faqs->isEmpty())
            <p class="text-center text-muted">Pertanyaan yang sering diajukan belum tersedia. Silakan hubungi kami melalui halaman <a href="/about/kontak-kami">Kontak</a>.</p>
        @else
            @foreach ($faqs as $kategori => $items)
                <div class="faq-category">
                    <h4 class="mb-3">{{ $kategori }}</h4>
                    <div class="accordion faq-accordion" id="faqAccordion{{ $loop->index }}">
                        @foreach ($items as $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $faq->id }}">
                                        {{ $faq->pertanyaan }}
                                    </button>
                                </h2>
                                <div id="faq{{ $faq->id }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion{{ $loop->parent->index }}">
                                    <div class="accordion-body">
                                        {{ $faq->jawaban }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif

        <div class="text-center mt-4">
            <p class="text-muted">Tidak menemukan jawaban yang Anda cari?</p>
            <a href="/about/kontak-kami" class="tp-btn tp-btn-insu">Hubungi Kami</a>
        </div>
    </div>
</main>

@include('layout.web.footer')
@endsection
