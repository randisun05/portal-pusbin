@extends('layout.main-main')
@section('container')
@include('layout.web.nav')

<main>
@include('layout.web.header-detail')

<!-- Main Content -->
<div class="container py-5">
    <div class="row">
            @foreach ($categories as $category )
        <div class="col col-md-4 mb-3">
            <div class="card text-bg-dark text-white">
                <a href="/publikasi?category={{$category->slug}}">
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
</main>

@include('layout.web.footer')
@endsection
<!-- End Of Main Content -->
