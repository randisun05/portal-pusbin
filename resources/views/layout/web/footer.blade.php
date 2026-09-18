<footer id="footer" class="footer light-background">

    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 footer-about">
                @include('layout.partial.logo')
                <p class="mt-3">Direktorat Jabatan Fungsional Manajemen Aparatur Sipil Negara (Direktorat JF MASN) &ndash; Badan Kepegawaian Negara Republik Indonesia.</p>
                <div class="social-links d-flex mt-4">
                    @if($profil->instagram ?? false)<a href="{{ $profil->instagram }}" target="_blank" rel="noopener"><i class="bi bi-instagram"></i></a>@endif
                    @if($profil->facebook ?? false)<a href="{{ $profil->facebook }}" target="_blank" rel="noopener"><i class="bi bi-facebook"></i></a>@endif
                    @if($profil->youtube ?? false)<a href="{{ $profil->youtube }}" target="_blank" rel="noopener"><i class="bi bi-youtube"></i></a>@endif
                    @if($profil->twitter ?? false)<a href="{{ $profil->twitter }}" target="_blank" rel="noopener"><i class="bi bi-twitter-x"></i></a>@endif
                </div>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Profil</h4>
                <ul>
                    <li><a href="/about/tentang-kami">Tentang Kami</a></li>
                    <li><a href="/about/kepala-pusat">Direktur</a></li>
                    <li><a href="/about/struktur-organisasi">Struktur Organisasi</a></li>
                    <li><a href="/about/visi-misi">Visi Misi</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-3 footer-links">
                <h4>Tautan Cepat</h4>
                <ul>
                    <li><a href="/publikasi">Publikasi</a></li>
                    <li><a href="/kegiatan">Kegiatan</a></li>
                    <li><a href="/survei">Survei</a></li>
                    <li><a href="/faq">FAQ</a></li>
                    <li><a href="/verifikasi-sertifikat">Verifikasi Sertifikat</a></li>
                    <li><a href="/sertifikat/unduh">Unduh Sertifikat</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-12 footer-contact-col">
                <h4>Kontak</h4>
                <div class="footer-contact pt-2">
                    <p>{{ $profil->alamat ?? 'Jl. Mayjen Sutoyo No. 12, Jakarta Timur, 13640 - Indonesia' }}</p>
                    @if($profil->telepon ?? false)
                        <p class="mt-2"><strong>Telepon:</strong> <span>{{ $profil->telepon }}</span></p>
                    @endif
                    @if($profil->email ?? false)
                        <p><strong>Email:</strong> <span>{{ $profil->email }}</span></p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>&copy; {{ date('Y') }} <strong class="px-1 sitename">Direktorat Jabatan Fungsional Manajemen Aparatur Sipil Negara</strong> &ndash; Badan Kepegawaian Negara. Seluruh hak cipta dilindungi.</p>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you've purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            Template oleh <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </div>

</footer>
