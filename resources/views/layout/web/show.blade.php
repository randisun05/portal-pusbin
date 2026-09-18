<!-- About Section -->
<section id="about" class="about section">

    <div class="container">

        <div class="row gy-4">

            <div class="col-lg-5 position-relative align-self-start" data-aos="fade-up" data-aos-delay="200">
                <img src="{{ asset('assets-flexor/img/about.jpg') }}" class="img-fluid rounded" alt="Tentang Direktorat JF MASN">
            </div>

            <div class="col-lg-7 content" data-aos="fade-up" data-aos-delay="100">
                <h3>Pelaksanaan Uji Kompetensi JFK</h3>
                <p>{{ \Illuminate\Support\Str::limit($profil->tentang ?? 'Direktorat Jabatan Fungsional Manajemen Aparatur Sipil Negara (Direktorat JF MASN) BKN menyelenggarakan uji kompetensi bagi pejabat fungsional kepegawaian secara profesional, transparan, dan mudah diakses di seluruh Indonesia.', 260) }}</p>
                <ul>
                    <li>
                        <i class="bi bi-calendar-check"></i>
                        <div>
                            <h5>Dilaksanakan 4 Periode Dalam 1 Tahun</h5>
                            <p>Jadwal ujikom terbuka setiap periode dan dapat diikuti sesuai jenjang jabatan fungsional.</p>
                        </div>
                    </li>
                    <li>
                        <i class="bi bi-laptop"></i>
                        <div>
                            <h5>Dilaksanakan Secara Full Daring</h5>
                            <p>Peserta dapat mengikuti seluruh proses tanpa perlu hadir secara fisik.</p>
                        </div>
                    </li>
                    <li>
                        <i class="bi bi-cash-coin"></i>
                        <div>
                            <h5>Tidak Dipungut Biaya</h5>
                            <p>Seluruh layanan Direktorat JF MASN diberikan tanpa biaya kepada peserta.</p>
                        </div>
                    </li>
                </ul>
                <a href="/about/tentang-kami" class="btn btn-primary mt-2">Selengkapnya <i class="bi bi-arrow-right"></i></a>
            </div>

        </div>

    </div>

</section><!-- /About Section -->
