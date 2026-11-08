@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.web.header-detail')

<!-- Main Content -->
<main>
    <section class="section">
    <div class="container">
        <form action="/publikasi" method="GET" class="row g-2 align-items-center mb-5">
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
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
        @if ($posts->count())
        <div class="row gy-4">
            @foreach ($posts as $post)
                @php
                    $postUrl = filter_var($post->link, FILTER_VALIDATE_URL) ? $post->link : '/publikasi/' . $post->slug;
                    $postImg = $post->image ? asset('storage/' . $post->image) : asset('assets-flexor/img/blog/blog-' . ((($loop->index % 5)) + 1) . '.jpg');
                @endphp
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 * (($loop->index % 6) + 1) }}">
                    <article>
                        <div class="post-img">
                            <img src="{{ $postImg }}" alt="{{ $post->title }}" class="img-fluid">
                        </div>
                        <p class="post-category">{{ $post->category->name }}</p>
                        <h2 class="title"><a href="{{ $postUrl }}">{{ $post->title }}</a></h2>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-circle flex-shrink-0 me-2"></i>
                            <div class="post-meta">
                                <p class="post-author mb-0">{{ optional($post->author)->name }}</p>
                                <p class="post-date mb-0">{{ $post->publish_at }}</p>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
        </div>
        @else
        <p class="text-center fs-4 text-muted">Tidak ada publikasi ditemukan.</p>
        @endif
    </div>
    </section>
</main>

@include('layout.web.footer')
@endsection
