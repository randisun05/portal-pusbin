<!-- Hero Section -->
<section id="hero" class="hero section dark-background">

    <img src="{{ asset('assets-flexor/img/hero-bg.jpg') }}" alt="" data-aos="fade-in">

    <div class="container position-relative">

        <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
            <h2>Direktorat Jabatan Fungsional MASN</h2>
            <p>Membina, mengembangkan, dan memfasilitasi jabatan fungsional kepegawaian di seluruh Indonesia secara profesional, transparan, dan mudah diakses.</p>
        </div><!-- End Welcome -->

        <div class="content row gy-4">
            <div class="col-lg-4 d-flex align-items-stretch">
                <div class="why-box" data-aos="zoom-out" data-aos-delay="200">
                    <h3>Kenapa Layanan Kami?</h3>
                    <p>{{ \Illuminate\Support\Str::limit($profil->tentang ?? 'Direktorat Jabatan Fungsional Manajemen Aparatur Sipil Negara (Direktorat JF MASN) BKN menyelenggarakan pembinaan jabatan fungsional kepegawaian secara profesional, transparan, dan mudah diakses di seluruh Indonesia.', 200) }}</p>
                    <div class="text-center">
                        <a href="/about/tentang-kami" class="more-btn"><span>Tentang Kami</span> <i class="bi bi-chevron-right"></i></a>
                    </div>
                </div>
            </div><!-- End Why Box -->

            <div class="col-lg-8 d-flex align-items-stretch">
                <div class="d-flex flex-column justify-content-center">
                    <div class="row gy-4">

                        <div class="col-xl-4 d-flex align-items-stretch">
                            <div class="icon-box" data-aos="zoom-out" data-aos-delay="300">
                                <i class="bi bi-clipboard-data"></i>
                                <h4>Uji Kompetensi</h4>
                                <p>Dilaksanakan 4 periode dalam setahun secara daring, tanpa dipungut biaya.</p>
                            </div>
                        </div>

                        <div class="col-xl-4 d-flex align-items-stretch">
                            <div class="icon-box" data-aos="zoom-out" data-aos-delay="400">
                                <i class="bi bi-headset"></i>
                                <h4>Konsultasi Online</h4>
                                <p>Ajukan pertanyaan seputar jabatan fungsional dan dapatkan nomor tiket jawaban.</p>
                            </div>
                        </div>

                        <div class="col-xl-4 d-flex align-items-stretch">
                            <div class="icon-box" data-aos="zoom-out" data-aos-delay="500">
                                <i class="bi bi-patch-check"></i>
                                <h4>Sertifikat Digital</h4>
                                <p>Unduh sertifikat kegiatan langsung, lengkap dengan QR verifikasi keaslian.</p>
                            </div>
                        </div>

                    </div>
                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a class="btn btn-primary" href="/layanan/pengajuan-rekomendasi">Lihat Layanan <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section><!-- /Hero Section -->
