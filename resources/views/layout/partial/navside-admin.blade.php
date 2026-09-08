@php
    $canManageOps = !auth()->user()->role_id || auth()->user()->hasRole(\App\Models\Role::SUPER_ADMIN, \App\Models\Role::ADMIN);
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
              <li class="menu-item {{ Request::is('admin/highlight*') ? 'active' : '' }}">
                <a href="/admin/highlight" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Hightlight</div>
                </a>
              </li>
            <li class="menu-item {{ Request::is('admin/publikasi*') ? 'active' : '' }}">
                <a href="/admin/publikasi" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Publikasi</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/comment*') ? 'active' : '' }}">
                <a href="/admin/comment" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Komentar Publikasi</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/faq*') ? 'active' : '' }}">
                <a href="/admin/faq" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">FAQ</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/layanan*') ? 'active' : '' }}">
                <a href="/admin/layanan" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Layanan</div>
                </a>
              </li>
              @if($canManageOps)
              <li class="menu-item {{ Request::is('admin/organisasi*') ? 'active' : '' }}">
                <a href="/admin/organisasi" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Struktur Organisasi</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/profil*') ? 'active' : '' }}">
                <a href="/admin/profil" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Profil Organisasi</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/misi*') ? 'active' : '' }}">
                <a href="/admin/misi" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Misi</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/pesankontak*') ? 'active' : '' }}">
                <a href="/admin/pesankontak" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Pesan Kontak</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/konsultasi*') ? 'active' : '' }}">
                <a href="/admin/konsultasi" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Jadwal Konsultasi</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/absensi') || Request::is('admin/absensi/*') ? 'active' : '' }}">
                <a href="/admin/absensi" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Absensi</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/absensi-statistik*') ? 'active' : '' }}">
                <a href="/admin/absensi-statistik" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Statistik Absensi</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/sertifikat*') ? 'active' : '' }}">
                <a href="/admin/sertifikat" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Sertifikat</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/jdihjfk*') ? 'active' : '' }}">
                <a href="/admin/jdihjfk" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">JDIH JFK</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/survei') || Request::is('admin/survei/*') ? 'active' : '' }}">
                <a href="/admin/survei" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Survei</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/survei-statistik*') ? 'active' : '' }}">
                <a href="/admin/survei-statistik" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Statistik Survei</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/auditlog*') ? 'active' : '' }}">
                <a href="/admin/auditlog" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Audit Trail</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/pengunjung*') ? 'active' : '' }}">
                <a href="/admin/pengunjung" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Monitoring Pengunjung</div>
                </a>
              </li>
              @endif
              <li class="menu-item {{ Request::is('admin/kegiatan*') ? 'active' : '' }}">
                <a href="/admin/kegiatan" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Kegiatan</div>
                </a>
              </li>
              @if(!auth()->user()->role_id || auth()->user()->isSuperAdmin())
              <li class="menu-item {{ Request::is('admin/register*') ? 'active' : '' }}">
                <a href="/admin/register" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Registrasi Admin</div>
                </a>
              </li>
              @endif
          </ul>
</aside>
    <!-- / Menu -->

