@extends('layout.main-main')

@section('container')

 <!-- Navbar & Hero Start -->

 <div class="container-fluid position-relative p-0">
    @include('layout.partial.nav')

    <!-- Baner BKN -->
    <div id="home" class="container-fluid hero-header">
        <img src="{{('assets/img/gallery/bg-header.png') }}" alt="">
    </div>
 </div>


<!-- Navbar & Hero End -->


<!-- About Start Ganti Jadi Bigtron -->

<div id ="highlight" class="container-xxl mt-5" >
    <div class="container px-lg-5">
        <div class="row g-5 align-items-center">
            <div class="wow fadeInUp" data-wow-delay="0.1s">
                 <p class="section-title text-secondary"><span></span>HIGHLIGHT<span></span></p>
               <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>

                    <div class="carousel-inner">
                    @foreach ($highlights as $key => $highlight )
                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}" data-bs-interval="5000">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{asset('storage/' . $highlight->image)}}" class="d-block w-100 h-100 img-fluid" alt="...">
                        </div>
                        <div class="carousel-caption d-none d-md-block">
                            <h5>{{ $highlight->name }}</h5>
                            <p>{{ $highlight->desc }}</p>
                        </div>
                    </div>

                    @endforeach
                </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- About End -->


<!-- Data Star -->
<div id="data" class="bg-primary factwow fadeInUp py-2 mt-4" data-wow-delay="0.1s">
    <p class="text-white text-center">Data Jabatan Fungsional Kepegawaian</p>
    <p class="text-white text-center">Per Oktober 2022</p>
    <div class="container px-lg-5">
            <div class="row g-4">
            <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.1s">
                <i class="fa fa-users fa-3x text-secondary mb-3"></i>
                <h1 class="text-white mb-2" data-toggle="counter-up">1234</h1>
                <p class="text-white mb-0">Analis SDMA</p>
            </div>
            <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.3s">
                <i class="fa fa-users fa-3x text-secondary mb-3"></i>
                <h1 class="text-white mb-2" data-toggle="counter-up">1234</h1>
                <p class="text-white mb-0">Pranata SDMA</p>
            </div>
            <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.5s">
                <i class="fa fa-users fa-3x text-secondary mb-3"></i>
                <h1 class="text-white mb-2" data-toggle="counter-up">1234</h1>
                <p class="text-white mb-0">Asesor SDMA</p>
            </div>
            <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.7s">
                <i class="fa fa-users fa-3x text-secondary mb-3"></i>
                <h1 class="text-white mb-2" data-toggle="counter-up">1234</h1>
                <p class="text-white mb-0">Auditor Manajemen ASN</p>
            </div>
        </div>
    </div>
</div>
<!-- Data End -->



<!-- Publikasi Start -->
<div id="info">
    <div class="container py-4 mb-5 mt-4">
        <div class="wow fadeInUp" data-wow-delay="0.1s">
            <p class="section-title text-secondary justify-content-center"><span></span>Publikasi<span></span></p>
            <h1 class="text-center mb-5">Informasi Terkini</h1>
        </div>
        <div class="container-fluid py-2">
            <div class="row g-4 portfolio-container">
                @foreach ($posts as $post )
                <div class="col-lg-4 col-md-4 portfolio-item first wow fadeInUp" data-wow-delay="0.1s">
                    <div class="rounded overflow-hidden">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{asset('storage/' . $post->image)}}" alt="">
                            <div class="portfolio-overlay">
                                @if(filter_var($post->slug, FILTER_VALIDATE_URL))
                                        <a class="btn btn-square btn-outline-light mx-1" href="{{ $post->slug }}" target="_blank">
                                            <i class="fa fa-link"></i>
                                        </a>
                                    @else
                                        <a class="btn btn-square btn-outline-light mx-1" href="/publikasi/{{ $post->slug }}" target="_blank">
                                            <i class="fa fa-link"></i>
                                        </a>
                                @endif
                            </div>
                        </div>
                        <div class="bg-light p-4">
                            @if(filter_var($post->slug, FILTER_VALIDATE_URL))
                            <a href="{{ $post->slug }}">
                                <p class="text-primary fs-6 fw-medium mb-2 text-justify">{{ $post->title }}</p>
                            </a>
                        @else
                            <a href="/publikasi/{{ $post->slug }}">
                                <p class="text-primary fs-6 fw-medium mb-2 text-justify">{{ $post->title }}</p>
                            </a>
                        @endif
                            <div style="text-align:justify;text-justify: "> <h6 class="fs-6 lh-base mb-0">  {{$post->excerpt}} </h6></a> </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="d-flex justify-content-center mt-4">
            <a href="/publikasi">Publikasi Lainnya</a>
        </div>
    </div>
</div>
<!-- Publikasi End -->


<!-- Service Start -->
<div id="layanan" class="container-xxl">
    <div class="container px-lg-5">
        <div class="wow fadeInUp" data-wow-delay="0.1s">
            <p class="section-title text-secondary justify-content-center"><span></span>Layanan Kami<span></span></p>
            <h1 class="text-center mb-5">Aplikasi Pendukung Layanan Kami</h1>
        </div>

            <div class="tembus px-2 py-4">
                <div class="row g-4 service-container">
                    @foreach ($layanans as $layanan )
                    @if ($layanan->aktif == 1)
                        <div class="col-lg-3 col-md-4 wow fadeInUp px-4" data-wow-delay="0.1s">
                            <a href={{$layanan->link}} target="_blank">
                            <div class="service-item d-flex flex-column text-center rounded">
                                <div class="service-icon flex-shrink-0">
                                    <img src="{{asset('storage/' . $layanan->image)}}" width="120 px">
                                </div>
                                <h5 class="mb-3">{{$layanan->nama}}</h5>
                                {{-- <p class="m-0">{{$layanan->deskripsi}}</p> --}}
                                @if ($layanan->aktif == 1)
                               </a>
                                @else
                                @include('errors.404')
                                @endif
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
    </div>
</div>

<style>
  .carousel-caption {
    background-color: rgba(128, 128, 128, 0.5);
    color: #fff;
    padding: 10px;
    border-radius: 10px;
  }
</style>
<!-- Service End -->



<!-- Footer Start -->
@include('layout.partial.footer')
<!-- Footer End -->


@endsection
