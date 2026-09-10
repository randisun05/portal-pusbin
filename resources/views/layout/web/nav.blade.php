<!-- tp-offcanvus-area-start -->
<div class="tpoffcanvas-area">
    <div class="tpoffcanvas">
        <div class="tpoffcanvas__close-btn">
            <button class="close-btn"><i class="fal fa-times"></i></button>
        </div>
        <div class="tpoffcanvas__logo">
            @include('layout.partial.logo')
        </div>
        <div class="tp-main-menu-mobile d-xl-none"></div>
        <div class="tpoffcanvas__social">
            <div class="social-icon">
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
</div>
<div class="body-overlay"></div>
<!-- tp-offcanvus-area-end -->
<!--search-form-start -->
<div class="tp-search-body-overlay"></div>
<!--search-form-start -->
<div class="tp-search-body-overlay"></div>
<div class="tp-search-form-toggle">
    <div class="tp-search-close">
        <i class="fa-solid fa-xmark"></i>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="tp-search-form">
                    <h4>WHAT ARE YOU LOOKING FOR?</h4>
                    <form action="/cari" method="GET">
                        <input type="text" name="q" placeholder="Search Here.." required>
                        <div class="tp-search-form-icon">
                            <button type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- search-form-end -->

<header class="tp-header-height">
    <!-- main-header-area-start -->
    <div class="tp-header-area tp-header-bottom-space-insu tp-white-bg" id="tp-header-sticky">
        <div class="container-fluid gx-0">
            <div class="row gx-0 align-items-center">
                <div class="col-xl-7 col-6">
                    <div class="tp-header-left tp-header-left-insu d-flex align-items-center">
                        <div class="tp-logo">
                            @include('layout.partial.logo')
                        </div>
                        <div class="tp-main-menu tp-main-menu-insu d-none d-xl-block">
                            <nav class="tp-main-menu-content">
                                <ul>
                                    <li class="has-dropdown position-static">
                                        <a href="/webpusbin" class="{{ Request::is('webpusbin') ? 'active' : '' }}">Beranda</a>
                                    </li>
                                    <li class="has-dropdown">
                                        <a href="#" class="{{ Request::is('about*',) ? 'active' : '' }}">Profil <i class="fa-solid fa-caret-down"></i></a>
                                        <ul class="tp-submenu submenu">
                                            <li class="has-dropdown">
                                                <ul>
                                                    <li><a href="/about/tentang-kami">Tentang Kami</a></li>
                                                    <li><a href="/about/kepala-pusat">Direktur</a></li>
                                                    <li><a href="/about/struktur-organisasi">Struktur Organisasi</a></li>
                                                    <li><a href="/about/visi-misi">Visi Misi</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="has-dropdown">
                                        <a href="#" class="{{ Request::is('layanan*',) ? 'active' : '' }}">Layanan <i class="fa-solid fa-caret-down"></i></a>
                                        <ul class="tp-submenu submenu" style="width: 300px">
                                            <li><a href="/layanan/pengajuan-rekomendasi">Usul Formasi JFK</a></li>
                                            <li><a href="/layanan/pengembangan-kompetensi">Pengembangan Kompetensi JFK</a></li>
                                            <li><a href="/layanan/uji-kompetensi">Uji Kompetensi JFK</a></li>
                                            <li><a href="/layanan/perpindahan-audiwan">Perpindahan JF Audiwan</a></li>
                                            <li><a href="/layanan/konversi-angka-kredit">Konversi Angka Kredit</a></li>
                                            <li><a href="/layanan/pengusulan-pak">Pengusulan PAK</a></li>
                                            <li><a href="/layanan/perubahan-nomenklatur">Perubahan Nomenklatur</a></li>
                                        </ul>
                                    </li>
                                    <li class="has-dropdown">
                                        <a href="#" class="{{ Request::is('publikasi*') ? 'active' : '' }}">Publikasi <i class="fa-solid fa-caret-down"></i></a>
                                        <ul class="tp-submenu submenu">
                                            <li><a href="/kegiatan">Kegiatan</a></li>
                                            <li><a href="/publikasi">Publikasi</a></li>
                                            <li> <a href="/categories">Data JFK</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <div class="tp-header-right d-flex align-items-center justify-content-end ">
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-6">
                    <div class="tp-header-right d-flex align-items-center justify-content-end ">
                        <div class="tp-main-menu tp-main-menu-insu d-none d-xl-block">
                            <nav class="tp-main-menu-content">
                                <ul>
                                    <li class="has-dropdown">
                                        <a href="#">HelpDesk <i class="fa-solid fa-caret-down"></i></a>
                                        <ul class="tp-submenu submenu">
                                            <li><a href="/faq">FAQ</a></li>
                                            <li><a href="/about/kontak-kami">Ajukan Pertanyaan</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/about/kontak-kami">Kontak Kami</a></li>
                                </ul>
                        </div>
                        <div class="tp-header-search-insu">
                            <button class="search-click">
                                <i class="flaticon-search"></i>
                            </button>
                        </div>
                        <div class="tp-menu-bar tp-header-hamburger-toogle tp-header-hamburger d-block d-xl-none">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main-header-area-end -->
</header>
