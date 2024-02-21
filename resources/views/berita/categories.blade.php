@extends('layout.main-main')
@section('container')
@include('layout.partial.header-componen')


<!-- Main Content -->

<div class="container">
    <div class="row">
            @foreach ($categories as $category )
        <div class="col col-md-4 mb-3">
            <div class="card text-bg-dark text-white mt-5">
                <a href="/publikasi?category={{$category->slug}}">
                <img src="/img/iconpengumuman.png" class="card-img" alt="{{$category->name}}" class="img-fluid">
                <div class="card-img-overlay d-flex align-items-center p-0">
                    <h5 class="card-title text-center flex-fill p-4 fs-3" style="background-color:rgba(0, 0, 0, 0.5)">{{$category->name}}</h5>
                </div>
            </div>
        </a>
        </div>
            @endforeach
    </div>
</div>
<div class="padingfooter">
@include('layout.partial.footer')
</div>
@endsection
<!-- End Of Main Content -->
