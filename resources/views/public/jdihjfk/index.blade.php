@extends('layout.main-main')
@section('container')
@include('layout.web.nav')

<main>
@include('layout.web.header-detail')

<section class="section">
<div class="container">
    <form action="/repository" method="GET" class="row g-2 justify-content-center mb-4">
        <div class="col-md-6">
            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Cari judul atau deskripsi peraturan...">
        </div>
        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

    @if ($jdihs->count())
        <div class="row g-4 justify-content-center">
            @foreach ($jdihs as $jdih )
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 * (($loop->index % 6) + 1) }}">
                <div class="rounded overflow-hidden shadow-sm h-100">
                    @if($jdih->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($jdih->image))
                        <img class="img-fluid" src="{{asset('storage/' . $jdih->image)}}" alt="{{ $jdih->title }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height: 180px;">
                            <i class="bi bi-file-earmark-text fs-1 text-muted"></i>
                        </div>
                    @endif
                    <div class="bg-light p-4">
                        @if($jdih->link)
                            <a href="{{ $jdih->link }}" target="_blank">
                                <p class="fw-medium mb-2" style="color: var(--accent-color);">{{ $jdih->title }} <i class="bi bi-box-arrow-up-right small"></i></p>
                            </a>
                        @else
                            <p class="fw-medium mb-2" style="color: var(--accent-color);">{{ $jdih->title }}</p>
                        @endif
                        <div class="prose-content"><h5 class="fs-6 lh-base mb-0">{{$jdih->deskripsi}}</h5></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p class="text-center fs-4 text-muted">Peraturan tidak ditemukan.</p>
    @endif

    <div class="d-flex justify-content-center mt-4">
        {{$jdihs->appends(request()->query())->links()}}
    </div>
</div>
</section>
</main>

@include('layout.web.footer')

@endsection
