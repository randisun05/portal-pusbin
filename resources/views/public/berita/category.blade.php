@extends('layout.main-main')
@include('layout.web.nav')
@include('layout.web.header-detail')
@section('container')

<h1 class="mb-5"> Publikasi dengan Kategori  : {{ $category }}    </h1>


<!-- Main Content -->
@if ($posts->count())
    <div class="container py-5 px-lg-5">
        <div class="row g-4 portfolio-container">
            @foreach ($posts as $post )
            <div class="col-lg-4 col-md-6 portfolio-item first wow fadeInUp" data-wow-delay="0.1s">
                <div class="rounded overflow-hidden">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="/img/pembukaanpj.jpg" alt="">
                        <div class="portfolio-overlay">
                            <a class="btn btn-square btn-outline-light mx-1" href="$post->image" data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
                            <a class="btn btn-square btn-outline-light mx-1" href="https://www.bkn.go.id/persetujuan-pindah-jabatan-mempertimbangkan-kualifikasi-pendidikan-pengalaman-dan-kompetensi/" target="_blank"><i class="fa fa-link"></i></a>
                        </div>
                    </div>
                    <div class="bg-light p-4">
                        <a href="/posts/{{$post->slug}}"> <p class="text-primary fw-medium mb-2">{{$post->title}}</p> </a>
                        <h5 class="lh-base mb-0">{{$post->excerpt}}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@else
<p class="text-center fs-4">No Post Found.</p>
@endif

<!-- End Of Main Content -->
@endsection
