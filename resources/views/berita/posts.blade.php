@extends('layout.main-main')
@section('container')
@include('layout.partial.header-componen-post')


{{-- menampilkan semua postingan di route --}}
        {{-- @foreach ($posts as $post )

    <article class="mb-5">
       <h2>
        <a href="/posts/{{$post->slug}}">{{$post->title}}</a>
        </h2>
       <p>{{$post->excerpt}}</p>
    </article>

    @endforeach --}}

<!-- Main Content -->

@if ($posts->count())
    <div class="container py-5 px-lg-5">
        <div class="row g-4 portfolio-container">
            @foreach ($posts as $post )
            <div class="col-lg-4 col-md-6 portfolio-item first wow fadeInUp" data-wow-delay="0.1s">
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
                        <div style="text-align:justify;text-justify: "> <h5 class="fs-6 lh-base mb-0">{{$post->excerpt}}</a> </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@else
<p class="text-center fs-4">No Post Found.</p>

@endif
    <div class="d-flex justify-content-center">
        {{$posts->links()}}
    </div>


<!-- End of Main Content -->
@include('layout.partial.footer')

@endsection
