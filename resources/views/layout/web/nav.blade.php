<header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center dark-background">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                @if($profil->email ?? false)
                    <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:{{ $profil->email }}">{{ $profil->email }}</a></i>
                @endif
                @if($profil->telepon ?? false)
                    <i class="bi bi-phone d-flex align-items-center ms-4"><span>{{ $profil->telepon }}</span></i>
                @endif
            </div>
            <div class="d-none d-md-flex align-items-center gap-4">
                <form action="/cari" method="GET" class="d-flex align-items-center topbar-search">
                    <input type="text" name="q" placeholder="Cari di situs ini.." class="form-control form-control-sm" style="width: 180px;">
                    <button type="submit" class="btn btn-sm btn-link text-white p-0 ms-1"><i class="bi bi-search"></i></button>
                </form>
                <div class="social-links d-flex align-items-center">
                    @if($profil->instagram ?? false)<a href="{{ $profil->instagram }}" target="_blank" rel="noopener" class="instagram"><i class="bi bi-instagram"></i></a>@endif
                    @if($profil->facebook ?? false)<a href="{{ $profil->facebook }}" target="_blank" rel="noopener" class="facebook"><i class="bi bi-facebook"></i></a>@endif
                    @if($profil->youtube ?? false)<a href="{{ $profil->youtube }}" target="_blank" rel="noopener" class="linkedin"><i class="bi bi-youtube"></i></a>@endif
                    @if($profil->twitter ?? false)<a href="{{ $profil->twitter }}" target="_blank" rel="noopener" class="twitter"><i class="bi bi-twitter-x"></i></a>@endif
                </div>
            </div>
        </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-center">
        <div class="container position-relative d-flex align-items-center justify-content-between">
            @include('layout.partial.logo')

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="/webpusbin" class="{{ Request::is('webpusbin') ? 'active' : '' }}">Beranda</a></li>
                    <li class="dropdown">
                        <a href="#" class="{{ Request::is('about*') ? 'active' : '' }}"><span>Profil</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="/about/tentang-kami">Tentang Kami</a></li>
                            <li><a href="/about/kepala-pusat">Direktur</a></li>
                            <li><a href="/about/struktur-organisasi">Struktur Organisasi</a></li>
                            <li><a href="/about/visi-misi">Visi Misi</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="{{ Request::is('layanan*') ? 'active' : '' }}"><span>Layanan</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="/layanan/pengajuan-rekomendasi">Usul Formasi JFK</a></li>
                            <li><a href="/layanan/pengembangan-kompetensi">Pengembangan Kompetensi JFK</a></li>
                            <li><a href="/layanan/uji-kompetensi">Uji Kompetensi JFK</a></li>
                            <li><a href="/layanan/perpindahan-audiwan">Perpindahan JF Audiwan</a></li>
                            <li><a href="/layanan/konversi-angka-kredit">Konversi Angka Kredit</a></li>
                            <li><a href="/layanan/pengusulan-pak">Pengusulan PAK</a></li>
                            <li><a href="/layanan/perubahan-nomenklatur">Perubahan Nomenklatur</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="{{ Request::is('publikasi*') || Request::is('kegiatan*') || Request::is('categories*') ? 'active' : '' }}"><span>Publikasi</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="/kegiatan">Kegiatan</a></li>
                            <li><a href="/publikasi">Publikasi</a></li>
                            <li><a href="/categories">Data JFK</a></li>
                        </ul>
                    </li>
                    <li><a href="/survei" class="{{ Request::is('survei*') ? 'active' : '' }}">Survei</a></li>
                    <li><a href="/repository" class="{{ Request::is('repository*') ? 'active' : '' }}">Repository</a></li>
                    <li class="dropdown">
                        <a href="#" class="{{ Request::is('faq*') || Request::is('sertifikat*') || Request::is('verifikasi-sertifikat*') ? 'active' : '' }}"><span>HelpDesk</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="/faq">FAQ</a></li>
                            <li><a href="/about/kontak-kami">Ajukan Pertanyaan</a></li>
                            <li><a href="/verifikasi-sertifikat">Verifikasi Sertifikat</a></li>
                            <li><a href="/sertifikat/unduh">Unduh Sertifikat</a></li>
                        </ul>
                    </li>
                    <li><a href="/about/kontak-kami" class="{{ Request::is('about/kontak-kami') ? 'active' : '' }}">Kontak Kami</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </div>

</header>
