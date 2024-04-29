<!-- blog-area-start -->
<div class="blog-area p-overflow pb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <div class="tp-section-title-wrapper text-center mb-60 wow fadeInUp" data-wow-delay=".3s" data-wow-duration="1s">
                            <span class="tp-section-title-pre tp-section-title-pre-5 mb-10">Berita</span>
                            <h2 class="tp-section-title tp-section-title-insu">Informasi Terkini</h2>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="tp-blog-btn-fin tp-blog-btn-fin-02 wow fadeInUp" data-wow-delay=".5s" data-wow-duration="1s">
                            <a href="/publikasi" class="tp-btn tp-btn-transparent">Selengkapnya<i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($posts as $post )
            <div class="col-lg-4 col-md-6">
                <div class="tp-blog-insu-wrapper p-relative mb-50 wow fadeInLeft" data-wow-delay=".3s" data-wow-duration="1s">
                    <div class="tp-blog-insu-img tp-thumb">
                        <div class="tp-thumb-overlay wow"></div>
                        <img src="assets/img/berita3.png" alt="blog">
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
    </div>
</div>
<!-- blog-area-end -->
