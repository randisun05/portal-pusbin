@extends('layout.main-main')

@section('container')

@include('layout.web.nav')

<main>
@include('layout.web.header-detail')

    <style>
        .tk-stat { border: 1px solid color-mix(in srgb, var(--default-color), transparent 90%); border-radius: 14px; padding: 22px 16px; text-align: center; background: var(--surface-color); transition: transform .2s, box-shadow .2s; }
        .tk-stat:hover { transform: translateY(-4px); box-shadow: 0 10px 24px rgba(20,20,43,.08); }
        .tk-stat h3 { font-size: 2rem; font-weight: 800; margin-bottom: 4px; color: var(--accent-color); }
        .tk-stat span { color: var(--default-color); font-size: .85rem; }
        .tk-content { white-space: pre-line; line-height: 1.9; }
    </style>

    <section class="section">
        <div class="container">

            <div class="row g-3 mb-5">
                <div class="col-6 col-md-3">
                    <div class="tk-stat" data-aos="fade-up" data-aos-delay="100">
                        <h3 class="tk-counter" data-count="{{ $jumlahOrganisasi }}">0</h3>
                        <span>Pejabat &amp; Tim</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="tk-stat" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="tk-counter" data-count="{{ $jumlahLayanan }}">0</h3>
                        <span>Layanan Aktif</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="tk-stat" data-aos="fade-up" data-aos-delay="300">
                        <h3 class="tk-counter" data-count="{{ $jumlahKegiatan }}">0</h3>
                        <span>Kegiatan Terlaksana</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="tk-stat" data-aos="fade-up" data-aos-delay="400">
                        <h3 class="tk-counter" data-count="{{ $jumlahPublikasi }}">0</h3>
                        <span>Publikasi</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-10 offset-xl-1 col-lg-12">
                    @if($profil->tentang)
                        <div class="tk-content prose-content mb-4">{{ $profil->tentang }}</div>
                    @else
                        <p class="text-muted mb-4">Profil organisasi belum diisi. Silakan lengkapi melalui menu admin &raquo; Profil Organisasi.</p>
                    @endif
                    <div class="d-flex flex-wrap gap-2">
                        <a href="/about/struktur-organisasi" class="btn btn-primary">Lihat Struktur Organisasi <i class="bi bi-arrow-right"></i></a>
                        <a href="/about/visi-misi" class="btn btn-outline-secondary">Visi &amp; Misi</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
