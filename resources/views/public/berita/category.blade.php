@extends('layout.main-main')
@section('container')
@include('layout.web.nav')

<main>
@include('layout.web.header-detail')

<!-- Main Content -->
<section class="section">
@if ($posts->count())
    <div class="container">
        <div class="row g-4">
            @foreach ($posts as $post )
                @php
                    $postImg = $post->image ? asset('storage/' . $post->image) : asset('assets-flexor/img/blog/blog-' . ((($loop->index % 5)) + 1) . '.jpg');
                @endphp
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 * (($loop->index % 6) + 1) }}">
                <div class="rounded overflow-hidden shadow-sm">
                    <img class="img-fluid w-100" src="{{ $postImg }}" alt="{{ $post->title }}">
                    <div class="bg-light p-4">
                        <a href="/publikasi/{{ $post->slug }}"><p class="fw-medium mb-2" style="color: var(--accent-color);">{{ $post->title }}</p></a>
                        <h5 class="lh-base mb-0">{{ $post->excerpt }}</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@else
<p class="text-center fs-4 py-5">Tidak ada publikasi ditemukan.</p>
@endif
</section>
<!-- End Of Main Content -->
</main>

@include('layout.web.footer')
@endsection
