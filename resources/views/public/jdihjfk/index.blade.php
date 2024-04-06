@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.web.header-detail')



@if ($jdihs->count())
    <div class="container py-5 px-lg-5">
        <div class="row g-4 portfolio-container" style="width: 70%">
            @foreach ($jdihs as $jdih )
            <div class="col-lg-4 col-md-6 portfolio-item first wow fadeInUp" data-wow-delay="0.1s">
                <div class="rounded overflow-hidden">
                    <div class="position-relative overflow-hidden">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="{{asset('storage/' . $jdih->image)}}" alt="">
                            <div class="portfolio-overlay">
                                <a class="btn btn-square btn-outline-light mx-1" href="{{ $jdih->link }}" target="_blank">
                                    <i class="fa fa-link"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bg-light p-4">
                                <a href="{{ $jdih->link }}">
                                    <p class="text-primary fs-6 fw-medium mb-2 text-justify">{{ $jdih->title }}</p>
                                </a>
                            <div style="text-align:justify;text-justify: "> <h5 class="fs-6 lh-base mb-0">{{$jdih->deskripsi}}</a> </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@else
<p class="text-center fs-4">Peraturan Tidak Ditemukan</p>

@endif
    <div class="d-flex justify-content-center">
        {{$jdihs->links()}}
    </div>


<!-- End of Main Content -->
@include('layout.web.footer')

@endsection
