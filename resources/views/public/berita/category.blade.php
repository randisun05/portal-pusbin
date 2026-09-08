@extends('layout.main-main')
@section('container')
@include('layout.web.nav')

<main>
@include('layout.web.header-detail')

<!-- Main Content -->
@if ($posts->count())
    <div class="container py-5 px-lg-5">
        <div class="row g-4 portfolio-container">
            @foreach ($posts as $post )
            <div class="col-lg-4 col-md-6 portfolio-item first wow fadeInUp" data-wow-delay="0.1s">
                <div class="rounded overflow-hidden">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                        <div class="portfolio-overlay">
                            <a class="btn btn-square btn-outline-light mx-1" href="/publikasi/{{ $post->slug }}"><i class="fa fa-eye"></i></a>
                        </div>
                    </div>
                    <div class="bg-light p-4">
                        <a href="/publikasi/{{ $post->slug }}"><p class="text-primary fw-medium mb-2">{{ $post->title }}</p></a>
                        <h5 class="lh-base mb-0">{{ $post->excerpt }}</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@else
<p class="text-center fs-4 py-5">No Post Found.</p>
@endif
<!-- End Of Main Content -->
</main>

@include('layout.web.footer')
@endsection
