@extends('layout.main-main')

@section('container')

@include('layout.web.nav')

<main>
@include('layout.web.header-detail')

    <style>
        .tk-stat { border: 1px solid #eceff3; border-radius: 14px; padding: 22px 16px; text-align: center; background: #fff; transition: transform .2s, box-shadow .2s; }
        .tk-stat:hover { transform: translateY(-4px); box-shadow: 0 10px 24px rgba(20,20,43,.08); }
        .tk-stat h3 { font-size: 2rem; font-weight: 800; margin-bottom: 4px; color: #f92c24; }
        .tk-stat span { color: #6c7382; font-size: .85rem; }
        .tk-content { white-space: pre-line; line-height: 1.9; }
    </style>

    <div class="tp-postbox-area pt-120 mb-70">
        <div class="container">

            <div class="row g-3 mb-5">
                <div class="col-6 col-md-3">
                    <div class="tk-stat wow fadeInUp" data-wow-delay="0.1s">
                        <h3 class="tk-counter" data-count="{{ $jumlahOrganisasi }}">0</h3>
                        <span>Pejabat &amp; Tim</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="tk-stat wow fadeInUp" data-wow-delay="0.2s">
                        <h3 class="tk-counter" data-count="{{ $jumlahLayanan }}">0</h3>
                        <span>Layanan Aktif</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="tk-stat wow fadeInUp" data-wow-delay="0.3s">
                        <h3 class="tk-counter" data-count="{{ $jumlahKegiatan }}">0</h3>
                        <span>Kegiatan Terlaksana</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="tk-stat wow fadeInUp" data-wow-delay="0.4s">
                        <h3 class="tk-counter" data-count="{{ $jumlahPublikasi }}">0</h3>
                        <span>Publikasi</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-10 offset-xl-1 col-lg-12 mb-50">
                    <div class="tp-postbox-wrapper">
                        <article class="tp-postbox-item mb-80 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="tp-postbox-content-2 mb-50 mt-20">
                                @if($profil->tentang)
                                    <div class="tk-content">{{ $profil->tentang }}</div>
                                @else
                                    <p class="text-muted">Profil organisasi belum diisi. Silakan lengkapi melalui menu admin &raquo; Profil Organisasi.</p>
                                @endif
                            </div>
                        </article>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="/about/struktur-organisasi" class="tp-btn tp-btn-insu">Lihat Struktur Organisasi <i class="fa-solid fa-arrow-right"></i></a>
                            <a href="/about/visi-misi" class="tp-btn tp-btn-transparent">Visi &amp; Misi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </main>

@include('layout.web.footer')

<script>
(function () {
    var counters = document.querySelectorAll('.tk-counter');
    var animated = false;

    function animate() {
        if (animated) return;
        animated = true;
        counters.forEach(function (el) {
            var target = parseInt(el.dataset.count, 10) || 0;
            var current = 0;
            var step = Math.max(1, Math.ceil(target / 40));
            var timer = setInterval(function () {
                current += step;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                el.textContent = current;
            }, 25);
        });
    }

    var target = document.querySelector('.tk-stat');
    if (target && 'IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animate();
                    observer.disconnect();
                }
            });
        });
        observer.observe(target);
    } else {
        animate();
    }
})();
</script>

@endsection
