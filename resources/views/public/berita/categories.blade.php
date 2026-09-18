@extends('layout.main-main')
@section('container')
@include('layout.web.nav')

<main>
@include('layout.web.header-detail')

<!-- Main Content -->
<section class="section">
<div class="container">
    <div class="row g-4">
            @foreach ($categories as $category )
        <div class="col col-md-4" data-aos="fade-up" data-aos-delay="{{ 100 * ($loop->index + 1) }}">
            <a href="/publikasi?category={{$category->slug}}" class="text-decoration-none">
                <div class="card text-bg-dark text-white">
                    <img src="{{ asset('assets/img/iconpengumuman.png') }}" class="card-img img-fluid" alt="{{$category->name}}">
                    <div class="card-img-overlay d-flex align-items-center p-0">
                        <h5 class="card-title text-center flex-fill p-4 fs-3" style="background-color:rgba(0, 0, 0, 0.5)">{{$category->name}}</h5>
                    </div>
                </div>
            </a>
        </div>
            @endforeach
    </div>
</div>
</section>
</main>

@include('layout.web.footer')
@endsection
<!-- End Of Main Content -->
