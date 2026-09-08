<footer class="tp-footer-modern">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="tp-footer-logo">
                    <img src="{{ asset('assets/img/logo/logo5.png') }}" alt="Pusbin JFK">
                </div>
                <p class="mb-0">Pusat Pembinaan Jabatan Fungsional Kepegawaian (Pusbin JFK) - Badan Kepegawaian Negara Republik Indonesia.</p>
            </div>

            <div class="col-lg-2 col-md-6">
                <h5>Profil</h5>
                <ul>
                    <li><a href="/about/tentang-kami">Tentang Kami</a></li>
                    <li><a href="/about/kepala-pusat">Kepala Pusat</a></li>
                    <li><a href="/about/struktur-organisasi">Struktur Organisasi</a></li>
                    <li><a href="/about/visi-misi">Visi Misi</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5>Tautan Cepat</h5>
                <ul>
                    <li><a href="/publikasi">Publikasi</a></li>
                    <li><a href="/kegiatan">Kegiatan</a></li>
                    <li><a href="/survei">Survei</a></li>
                    <li><a href="/faq">FAQ</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5>Kontak</h5>
                <div class="tp-footer-info-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>{{ $profil->alamat ?? 'Jl. Mayjen Sutoyo No. 12, Jakarta Timur, 13640 - Indonesia' }}</span>
                </div>
                @if($profil->telepon)
                    <div class="tp-footer-info-item">
                        <i class="fa-solid fa-phone"></i>
                        <span>{{ $profil->telepon }}</span>
                    </div>
                @endif
                @if($profil->email)
                    <div class="tp-footer-info-item">
                        <i class="fa-solid fa-envelope"></i>
                        <span>{{ $profil->email }}</span>
                    </div>
                @endif
                <div class="tp-footer-social mt-3">
                    @if($profil->instagram)<a href="{{ $profil->instagram }}" target="_blank" rel="noopener"><i class="fa-brands fa-instagram"></i></a>@endif
                    @if($profil->facebook)<a href="{{ $profil->facebook }}" target="_blank" rel="noopener"><i class="fa-brands fa-facebook-f"></i></a>@endif
                    @if($profil->youtube)<a href="{{ $profil->youtube }}" target="_blank" rel="noopener"><i class="fa-brands fa-youtube"></i></a>@endif
                    @if($profil->twitter)<a href="{{ $profil->twitter }}" target="_blank" rel="noopener"><i class="fa-brands fa-twitter"></i></a>@endif
                </div>
            </div>
        </div>

        <div class="tp-footer-bottom-bar">
            &copy; {{ date('Y') }} Pusat Pembinaan Jabatan Fungsional Kepegawaian | Badan Kepegawaian Negara. Seluruh hak cipta dilindungi.
        </div>
    </div>
</footer>
