<!-- Stats Section -->
<section id="stats" class="stats-counter section light-background">
    <div class="container">
        <div class="row gy-4">

            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center" data-aos="fade-up" data-aos-delay="100">
                    <span class="counter2 home-counter" data-count="{{ $jumlahOrganisasi }}">0</span>
                    <p>{{ $profil->stat_label_organisasi ?? 'Pejabat & Tim' }}</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center" data-aos="fade-up" data-aos-delay="200">
                    <span class="counter2 home-counter" data-count="{{ $jumlahLayanan }}">0</span>
                    <p>{{ $profil->stat_label_layanan ?? 'Layanan Aktif' }}</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center" data-aos="fade-up" data-aos-delay="300">
                    <span class="counter2 home-counter" data-count="{{ $jumlahKegiatan }}">0</span>
                    <p>{{ $profil->stat_label_kegiatan ?? 'Kegiatan Terlaksana' }}</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center" data-aos="fade-up" data-aos-delay="400">
                    <span class="counter2 home-counter" data-count="{{ $jumlahPublikasi }}">0</span>
                    <p>{{ $profil->stat_label_publikasi ?? 'Publikasi' }}</p>
                </div>
            </div>

        </div>
    </div>
</section><!-- /Stats Section -->

<script>
(function () {
    var counters = document.querySelectorAll('.home-counter');
    if (!counters.length) return;
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

    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animate();
                    observer.disconnect();
                }
            });
        });
        observer.observe(counters[0]);
    } else {
        animate();
    }
})();
</script>
