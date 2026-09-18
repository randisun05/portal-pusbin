<!-- Services Section -->
<section id="services" class="services section light-background">

    <div class="container section-title" data-aos="fade-up">
        <h2>Layanan Kami</h2>
        <p>Berbagai layanan Direktorat Jabatan Fungsional Manajemen Aparatur Sipil Negara</p>
    </div>

    <div class="container">
        <div class="row gy-4">
            @foreach ($layanans as $layanan)
                @php
                    $hasImage = $layanan->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($layanan->image);
                @endphp
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 * ($loop->index + 1) }}">
                    <div class="service-item-photo position-relative">
                        @if($hasImage)
                            <img src="{{ asset('storage/' . $layanan->image) }}" alt="{{ $layanan->nama }}">
                        @else
                            <i class="bi bi-diagram-3 fallback-icon"></i>
                        @endif
                        <a href="{{ $layanan->link }}" class="stretched-link">
                            <h3>{{ $layanan->nama }}</h3>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</section><!-- /Services Section -->
