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
              <li class="menu-item {{ Request::is('admin/layanan*') ? 'active' : '' }}">
                <a href="/admin/layanan" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Layanan</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/dashboard*') ? 'active' : '' }}">
                <a href="/admin/dashboard" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Dashboard</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/konsultasi*') ? 'active' : '' }}">
                <a href="/admin/konsultasi" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Jadwal Konsultasi</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/jadwalukom*') ? 'active' : '' }}">
                <a href="/admin/jadwalukom" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Jadwal UKom</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/kegiatan*') ? 'active' : '' }}">
                <a href="/admin/kegiatan" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Kegiatan</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/absensi*') ? 'active' : '' }}">
                <a href="/admin/absensi" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Absensi</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/jdihjfk*') ? 'active' : '' }}">
                <a href="/admin/jdihjfk" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">JDIH JFK</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/survei*') ? 'active' : '' }}">
                <a href="/admin/survei" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Survei</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('admin/register*') ? 'active' : '' }}">
                <a href="/admin/register" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Registrasi Admin</div>
                </a>
              </li>
          </ul>
</aside>
    <!-- / Menu -->

