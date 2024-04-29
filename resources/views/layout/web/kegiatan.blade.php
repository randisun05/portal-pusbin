<!-- blog-area-start -->
<div class="blog-area p-relative pb-70">
    <div class="tp-blog-border"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="tp-section-title-wrapper mb-60 p-relative wow fadeInUp" data-wow-delay=".3s" data-wow-duration="1s">
                    <span class="tp-section-title-pre tp-section-title-pre4">// Jangan Lewatkan</span>
                    <h2 class="tp-section-title">Kegiatan Kami Selanjutnya</h2>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="tp-blog-btn-fin tp-blog-btn-fin-02 wow fadeInUp" data-wow-delay=".5s" data-wow-duration="1s">
                    <a href="/kegiatan" class="tp-btn tp-btn-transparent">Selengkapnya<i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($kegiatans as $kegiatan)
            <div class="col-lg-4 col-md-6">
                <div class="tp-blog-wrapper mb-50 wow fadeInUp" data-wow-delay=".3s" data-wow-duration="1s">
                    <div class="tp-blog-main-img mb-15 p-relative">
                        <img class="w-img" src="{{asset ('assets/img/konsul2.png') }}" alt="blog">
                        <img class="w-img" src="{{asset ('assets/img/konsul2.png') }}" alt="blog">
                    </div>
                    <div class="tp-blog-content">
                        <div class="tp-blog-meta mb-15">
                            <span class="tp-blog-sub-meta tp-blog-sub-meta-fin p-relative"><a href="absensi/{{ $kegiatan->slug }}">{{$kegiatan->waktu}}</a></span>
                            <span class="tp-blog-date p-relative">23 June, 2024</span>
                        </div>
                        <h3 class="tp-blog-title tp-blog-title-2 mb-25"><a href="absensi/{{ $kegiatan->slug }}">{{ $kegiatan->nama }}</a></h3>
                        <a href="kegiatan/{{ $kegiatan->slug }}" class="tp-blog-btn-2">View<i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- blog-area-end -->

