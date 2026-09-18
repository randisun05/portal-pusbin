<!-- Kegiatan Section -->
<section id="kegiatan" class="blog-posts section">

    <div class="container">
        <div class="row align-items-center mb-4">
            <div class="col-lg-8">
                <div class="section-title text-start" data-aos="fade-up">
                    <h2>Kegiatan Kami Selanjutnya</h2>
                    <p>Jangan lewatkan kegiatan &amp; ujikom yang akan datang</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="/kegiatan" class="more-btn"><span>Semua Kegiatan</span> <i class="bi bi-chevron-right"></i></a>
            </div>
        </div>

        <div class="row gy-4">
            @forelse ($kegiatans as $kegiatan)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 * ($loop->index + 1) }}">
                    <article>
                        <div class="post-img">
                            <img src="{{ asset('storage/' . $kegiatan->image) }}" alt="{{ $kegiatan->nama }}" class="img-fluid">
                        </div>
                        <p class="post-category">{{ $kegiatan->jenis }}</p>
                        <h2 class="title"><a href="/kegiatan/{{ $kegiatan->slug }}">{{ $kegiatan->nama }}</a></h2>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-event flex-shrink-0 me-2"></i>
                            <div class="post-meta">
                                <p class="post-date mb-0">{{ $kegiatan->waktu }}</p>
                            </div>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12 text-center text-muted">Belum ada kegiatan mendatang.</div>
            @endforelse
        </div>
    </div>

</section><!-- /Kegiatan Section -->
