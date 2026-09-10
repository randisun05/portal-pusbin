@php
    $me = auth()->user();
@endphp
<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <span class="menu-text fw-bolder ms-2 fs-4">Admin Website</span>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
          <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
      <div class="menu-inner-shadow"></div>
          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item {{ Request::is('admin') ? 'active' : '' }}">
              <a href="/admin" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>
            <li class="menu-header small text-uppercase mt-3">
                <span class="menu-header-text">MENU WEB</span>
              </li>
              @if($me->hasPermission('manage-highlight'))
              <li class="menu-item {{ Request::is('admin/highlight*') ? 'active' : '' }}">
                <a href="/admin/highlight" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Hightlight</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('manage-publikasi'))
            <li class="menu-item {{ Request::is('admin/publikasi*') ? 'active' : '' }}">
                <a href="/admin/publikasi" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Publikasi</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('manage-comment'))
              <li class="menu-item {{ Request::is('admin/comment*') ? 'active' : '' }}">
                <a href="/admin/comment" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Komentar Publikasi</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('manage-faq'))
              <li class="menu-item {{ Request::is('admin/faq*') ? 'active' : '' }}">
                <a href="/admin/faq" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">FAQ</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('manage-layanan'))
              <li class="menu-item {{ Request::is('admin/layanan*') ? 'active' : '' }}">
                <a href="/admin/layanan" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Layanan</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('manage-kegiatan'))
              <li class="menu-item {{ Request::is('admin/kegiatan*') ? 'active' : '' }}">
                <a href="/admin/kegiatan" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Kegiatan</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('manage-organisasi'))
              <li class="menu-item {{ Request::is('admin/organisasi*') ? 'active' : '' }}">
                <a href="/admin/organisasi" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Struktur Organisasi</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('manage-profil'))
              <li class="menu-item {{ Request::is('admin/profil*') ? 'active' : '' }}">
                <a href="/admin/profil" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Profil Organisasi</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('manage-misi'))
              <li class="menu-item {{ Request::is('admin/misi*') ? 'active' : '' }}">
                <a href="/admin/misi" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Misi</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('manage-pesankontak'))
              <li class="menu-item {{ Request::is('admin/pesankontak*') ? 'active' : '' }}">
                <a href="/admin/pesankontak" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Pesan Kontak</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('manage-konsultasi'))
              <li class="menu-item {{ Request::is('admin/konsultasi') || Request::is('admin/konsultasi/*') ? 'active' : '' }}">
                <a href="/admin/konsultasi" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Jadwal Konsultasi</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/konsultasi-tiket*') ? 'active' : '' }}">
                <a href="/admin/konsultasi-tiket" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Tiket Konsultasi</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('manage-absensi'))
              <li class="menu-item {{ Request::is('admin/absensi') || Request::is('admin/absensi/*') ? 'active' : '' }}">
                <a href="/admin/absensi" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Absensi</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('view-statistik'))
              <li class="menu-item {{ Request::is('admin/absensi-statistik*') ? 'active' : '' }}">
                <a href="/admin/absensi-statistik" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Statistik Absensi</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('manage-jadwalukom'))
              <li class="menu-item {{ Request::is('admin/jadwalukom*') ? 'active' : '' }}">
                <a href="/admin/jadwalukom" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Jadwal Ujikom</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('manage-sertifikat'))
              <li class="menu-item {{ Request::is('admin/sertifikat*') ? 'active' : '' }}">
                <a href="/admin/sertifikat" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Sertifikat</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('manage-repository'))
              <li class="menu-item {{ Request::is('admin/repository*') ? 'active' : '' }}">
                <a href="/admin/repository" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Repository</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('manage-survei'))
              <li class="menu-item {{ Request::is('admin/survei') || Request::is('admin/survei/*') ? 'active' : '' }}">
                <a href="/admin/survei" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Survei</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('view-statistik'))
              <li class="menu-item {{ Request::is('admin/survei-statistik*') ? 'active' : '' }}">
                <a href="/admin/survei-statistik" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Statistik Survei</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('view-statistik'))
              <li class="menu-item {{ Request::is('admin/konsultasi-statistik*') ? 'active' : '' }}">
                <a href="/admin/konsultasi-statistik" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Statistik Konsultasi</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('view-statistik'))
              <li class="menu-item {{ Request::is('admin/survei-kepuasan*') ? 'active' : '' }}">
                <a href="/admin/survei-kepuasan" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Dashboard Kepuasan</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('view-auditlog'))
              <li class="menu-item {{ Request::is('admin/auditlog*') ? 'active' : '' }}">
                <a href="/admin/auditlog" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Audit Trail</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('view-pengunjung'))
              <li class="menu-item {{ Request::is('admin/pengunjung*') ? 'active' : '' }}">
                <a href="/admin/pengunjung" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Monitoring Pengunjung</div>
                </a>
              </li>
              @endif
              @if($me->hasPermission('manage-users'))
              <li class="menu-item {{ Request::is('admin/register*') ? 'active' : '' }}">
                <a href="/admin/register" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Registrasi Admin</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/role*') ? 'active' : '' }}">
                <a href="/admin/role" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Role &amp; Permission</div>
                </a>
              </li>
              @endif
          </ul>
</aside>
    <!-- / Menu -->

