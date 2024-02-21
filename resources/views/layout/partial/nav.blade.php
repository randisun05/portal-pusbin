<nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
    <!-- Buat Logo or WordArt -->
    <a href="" class="navbar-brand p-0">
        <h1 class="m-0">Pusbin JFK</h1>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav mx-auto py-0">
            <li class="nav-item">
            <a  class="nav-link active" href="/">Home</a>
            </li>
            <li class="nav-item">
            <a  class="nav-link {{ Request::is('*#highlight* ') ? 'active' : '' }}" href="/webpusbin#highlight">Highlight</a>
            </li>
            <li class="nav-item">
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle {{ Request::is('layanan*',) ? 'active' : '' }}" data-bs-toggle="dropdown">Layanan</a>
                    <div class="dropdown-menu m-0">
                        <a href="/layanan/pengajuan-rekomendasi" class="dropdown-item">Rekomendasi Kebutuhan</a>
                        <a href="/layanan/pengembangan-kompetensi" class="dropdown-item">Pengembangan Kompetensi</a>
                        <a href="/layanan/pendaftaran-ujikom" class="dropdown-item">Pendaftaran Uji Kompetensi</a>
                        {{-- <a href="/layanan/perubahan-nomenklatur" class="dropdown-item">Perubahan Nomenklatur</a>
                        <a href="/layanan/konversi-ak" class="dropdown-item">Konversi Angka Kredit</a> --}}
                        <a href="/layanan/perpindahan-audiwan" class="dropdown-item">Perpindahan JF Audiwan ke JF lain</a>
                        {{-- <a href="/layanan/pengusulan-pak" class="dropdown-item">Pengusulan PAK</a> --}}
                    </div>
                </li>

            <li class="nav-item dropdown">
                <a href="/#kegiatan" class="nav-link dropdown-toggle {{ Request::is('publikasi*','categories') ? 'active' : '' }}" data-bs-toggle="dropdown">Publikasi</a>
                <div class="dropdown-menu m-0">
                    <a href="/webpusbin#info" class="dropdown-item">Informasi Terkini</a>
                    <a href="/publikasi" class="dropdown-item">Daftar Publikasi</a>
                    <a href="/categories" class="dropdown-item">Kategori Publikasi</a>
                    <a href="404.html" class="dropdown-item">-</a>
                </div>
            </li>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ Request::is('','') ? 'active' : '' }}" data-bs-toggle="dropdown">Lainnya</a>
                <div class="dropdown-menu m-0">
                    <a href="#data" class="dropdown-item">Data JFK</a>
                    <a href="/webpusbin#layanan" class="dropdown-item">Aplikasi Pendukung Layanan Kami</a>
                    <a href="#" class="dropdown-item">-</a>
                    <a href="404.html" class="dropdown-item">404 Page</a>
                </div>
            </div>
        </div>
    </div>
</nav>
