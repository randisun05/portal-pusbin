@extends('layout.main-main')
@section('container')
@include('layout.web.nav')

<main>
<!-- breadcrumb-area-start -->
<div class="tp-breadcrumb-area-7 bg-position-default" data-background="{{asset ('assets/img/breadcrumb/breadcrumb-bg8.jpg') }}">
    <div class="container-fluid">
       <div class="row">
        <div class="col-lg-12">
            <div class="tp-breadcrumb-list-5 pt-200 pb-185 text-center wow fadeInUp" data-wow-delay=".3s" data-wow-duration="1s">
                <h2 class="tp-breadcrumb-title-2 mb-20">{{ $title }}</h2>
                <div class="tp-breadcrumb-list-inner-2">
                   <span><a href="index.html">Beranda </a></span>
                   <span class="tp-breadcrumb-dvdr"> /</span>
                   <span>{{ $title }}</span>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
 <!-- breadcrumb-area-end -->



</main>


@include('layout.web.footer')
@endsection
