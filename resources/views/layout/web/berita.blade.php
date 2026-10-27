<!-- Publikasi Section -->
<section id="publikasi" class="blog-posts section light-background">

    <div class="container">
        <div class="row align-items-center mb-4">
            <div class="col-lg-8">
                <div class="section-title text-start" data-aos="fade-up">
                    <h2>Informasi Terkini</h2>
                    <p>Publikasi &amp; berita terbaru dari Direktorat JF MASN</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="/publikasi" class="more-btn"><span>Semua Publikasi</span> <i class="bi bi-chevron-right"></i></a>
            </div>
        </div>

        <div class="row gy-4">
            @forelse ($posts as $post)
                @php
                    $postUrl = filter_var($post->link, FILTER_VALIDATE_URL) ? $post->link : '/publikasi/' . $post->slug;
                    $postImg = $post->image ? asset('storage/' . $post->image) : asset('assets-flexor/img/blog/blog-' . ((($loop->index % 5)) + 1) . '.jpg');
                @endphp
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 * ($loop->index + 1) }}">
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
                            </div>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12 text-center text-muted">Belum ada publikasi.</div>
            @endforelse
        </div>
    </div>

</section><!-- /Publikasi Section -->
