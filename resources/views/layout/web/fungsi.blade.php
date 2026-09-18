<!-- Fungsi Interaktif Section -->
<section id="fungsi-interaktif" class="services section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Fungsi &amp; Layanan Interaktif</h2>
        <p>Akses langsung ke layanan digital Direktorat JF MASN</p>
    </div>
    <div class="container">
        <div class="row gy-5">
            @forelse ($fungsiHighlights as $item)
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 * ($loop->index + 1) }}">
                    <div class="service-item">
                        <div class="icon"><i class="bi {{ $item->icon ?: 'bi-star' }}"></i></div>
                        <a href="{{ $item->link ?: '#' }}" class="stretched-link"><h3>{{ $item->name }}</h3></a>
                        <p>{{ $item->desc }}</p>
                    </div>
                </div>
            @empty
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item">
                        <div class="icon"><i class="bi bi-clipboard2-pulse"></i></div>
                        <a href="/survei" class="stretched-link"><h3>Survei Kepuasan</h3></a>
                        <p>Berikan penilaian Anda atas layanan kami dan ikuti survei yang sedang berjalan.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section><!-- /Fungsi Interaktif Section -->
