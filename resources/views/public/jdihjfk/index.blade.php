@extends('layout.main-main')
@section('container')
@include('layout.web.nav')

<main>
@include('layout.web.header-detail')

<div class="container py-5 px-lg-5">
    <form action="/jdihjfk" method="GET" class="row g-2 justify-content-center mb-4">
        <div class="col-md-6">
            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Cari judul atau deskripsi peraturan...">
        </div>
        <div class="col-md-2 d-grid">
            <button type="submit" class="tp-btn tp-btn-insu">Cari</button>
        </div>
    </form>

    @if ($jdihs->count())
        <div class="row g-4 justify-content-center">
            @foreach ($jdihs as $jdih )
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="rounded overflow-hidden">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid" src="{{asset('storage/' . $jdih->image)}}" alt="{{ $jdih->title }}">
                        <div class="portfolio-overlay">
                            <a class="btn btn-square btn-outline-light mx-1" href="{{ $jdih->link }}" target="_blank">
                                <i class="fa fa-link"></i>
                            </a>
                        </div>
                    </div>
                    <div class="bg-light p-4">
                        <a href="{{ $jdih->link }}" target="_blank">
                            <p class="text-primary fs-6 fw-medium mb-2 text-justify">{{ $jdih->title }}</p>
                        </a>
                        <div style="text-align:justify;text-justify: "><h5 class="fs-6 lh-base mb-0">{{$jdih->deskripsi}}</h5></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p class="text-center fs-4">Peraturan Tidak Ditemukan</p>
    @endif

    <div class="d-flex justify-content-center mt-4">
        {{$jdihs->appends(request()->query())->links()}}
    </div>
</div>
</main>

@include('layout.web.footer')

@endsection
