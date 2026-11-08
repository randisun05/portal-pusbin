<!-- Peraturan Terbaru Section -->
@if($peraturans->isNotEmpty())
<section id="peraturan" class="blog-posts section light-background">

    <div class="container">
        <div class="row align-items-center mb-4">
            <div class="col-lg-8">
                <div class="section-title text-start" data-aos="fade-up">
                    <h2>Peraturan &amp; Referensi Terbaru</h2>
                    <p>Dokumen dan regulasi terbaru seputar jabatan fungsional kepegawaian</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="/repository" class="more-btn"><span>Semua Repository</span> <i class="bi bi-chevron-right"></i></a>
            </div>
        </div>

        <div class="row gy-4">
            @foreach ($peraturans as $peraturan)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 * ($loop->index + 1) }}">
                    <article>
                        <div class="post-img">
                            @php
                                $peraturanHasImage = $peraturan->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($peraturan->image);
                            @endphp
                            @if($peraturanHasImage)
                                <img src="{{ asset('storage/' . $peraturan->image) }}" alt="{{ $peraturan->title }}" class="img-fluid">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                    <i class="bi bi-file-earmark-text fs-1 text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <h2 class="title">
                            @if($peraturan->link)
                                <a href="{{ $peraturan->link }}" target="_blank">{{ $peraturan->title }}</a>
                            @else
                                <a href="/repository">{{ $peraturan->title }}</a>
                            @endif
                        </h2>
                        <p class="text-muted small mb-0">{{ \Illuminate\Support\Str::limit($peraturan->deskripsi, 90) }}</p>
                    </article>
                </div>
            @endforeach
        </div>
    </div>

</section><!-- /Peraturan Terbaru Section -->
@endif
