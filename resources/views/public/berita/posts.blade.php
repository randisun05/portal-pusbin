@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.web.header-detail')

<!-- Main Content -->
<main>
    <div class="container mt-50">
        <form action="/publikasi" method="GET" class="row g-2 align-items-center mb-4">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="Cari judul atau isi publikasi...">
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ $categorySlug === $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="tp-btn tp-btn-insu">Cari</button>
            </div>
        </form>
        @if ($posts->count())
        <div class="row">
            @foreach ($posts as $post)
            <div class="col-lg-4 col-md-6">
                <div class="tp-blog-insu-wrapper p-relative mb-50 wow fadeInLeft" data-wow-delay=".3s" data-wow-duration="1s">
                    <div class="tp-blog-insu-img tp-thumb">
                        <div class="tp-thumb-overlay wow"></div>
                        <img src="{{asset ('assets/img/blog/blog02.jpg') }}" alt="blog">
                    </div>
                    <div class="tp-blog-insu-content p-absolute">
                        <div class="tp-blog-insu-top d-flex align-items-center">
                            <h4 class="tp-blog-insu-name"><a href="{{ filter_var($post->link, FILTER_VALIDATE_URL) ? $post->link : '/publikasi/' . $post->slug }}">{{ $post->category->name }}</a></h4>
                            <span class="tp-blog-insu-date">{{ $post->publish_at }}</span>
                        </div>
                        <h3 class="tp-blog-insu-title"><a href="{{ filter_var($post->link, FILTER_VALIDATE_URL) ? $post->link : '/publikasi/' . $post->slug }}">{{ $post->title }}</a></h3>
                        <a class="tp-blog-insu-link" href="{{ filter_var($post->link, FILTER_VALIDATE_URL) ? $post->link : '/publikasi/' . $post->slug }}">Baca <i class="fa-regular fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{$posts->links()}}
        </div>
        @else
        <p class="text-center fs-4">No Post Found.</p>
        @endif
    </div>
</main>


<!-- End of Main Content -->
@include('layout.web.footer')

@endsection
