<!-- About Section -->
<section id="about" class="about section">

    <div class="container">

        <div class="row gy-4">

            <div class="col-lg-5 position-relative align-self-start" data-aos="fade-up" data-aos-delay="200">
                <img src="{{ asset('assets-flexor/img/about.jpg') }}" class="img-fluid rounded" alt="Tentang Direktorat JF MASN">
            </div>

            <div class="col-lg-7 content" data-aos="fade-up" data-aos-delay="100">
                <h3>{{ $profil->about_judul ?? 'Pelaksanaan Uji Kompetensi JFK' }}</h3>
                <p>{{ \Illuminate\Support\Str::limit($profil->tentang ?? 'Direktorat Jabatan Fungsional Manajemen Aparatur Sipil Negara (Direktorat JF MASN) BKN menyelenggarakan uji kompetensi bagi pejabat fungsional kepegawaian secara profesional, transparan, dan mudah diakses di seluruh Indonesia.', 260) }}</p>
                <ul>
                    @forelse ($aboutHighlights as $item)
                        <li>
                            <i class="bi {{ $item->icon ?: 'bi-check-circle' }}"></i>
                            <div>
                                <h5>{{ $item->name }}</h5>
                                <p>{{ $item->desc }}</p>
                            </div>
                        </li>
                    @empty
                        <li>
                            <i class="bi bi-calendar-check"></i>
                            <div>
                                <h5>Dilaksanakan 4 Periode Dalam 1 Tahun</h5>
                                <p>Jadwal ujikom terbuka setiap periode dan dapat diikuti sesuai jenjang jabatan fungsional.</p>
                            </div>
                        </li>
                    @endforelse
                </ul>
                <a href="/about/tentang-kami" class="btn btn-primary mt-2">Selengkapnya <i class="bi bi-arrow-right"></i></a>
            </div>

        </div>

    </div>

</section><!-- /About Section -->
