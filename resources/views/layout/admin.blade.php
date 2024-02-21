<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{asset('assets-admin/')}}"
  data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <title>Admin Web Pusbin</title>
    <meta name="description" content="" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets-admin/img/favicon/favicon.ico" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('assets-admin/vendor/fonts/boxicons.css')}}" />
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('assets-admin/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('assets-admin/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('assets-admin/css/demo.css')}}" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('assets-admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('assets-admin/vendor/libs/apex-charts/apex-charts.css')}}" />
    <!-- Page CSS -->
    <!-- Helpers -->
    <script src="{{asset('assets-admin/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('assets-admin/js/config.js')}}"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
                     <!-- Menu -->
                    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                            <div class="app-brand demo">
                                <span class="app-brand-text demo menu-text fw-bolder ms-2">Admin</span>
                                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                                </a>
                            </div>
                        <div class="menu-inner-shadow"></div>
                            <ul class="menu-inner py-1">
                                    <!-- Dashboard -->
                                <li class="menu-item active">
                                    <a href="index.html" class="menu-link">
                                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                                        <div data-i18n="Analytics">Dashboard</div>
                                    </a>
                                </li>
                                <li class="menu-header small text-uppercase">
                                    <span class="menu-header-text">Pages</span>
                                </li>
                                <li class="menu-item">
                                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                                        <i class="menu-icon tf-icons bx bx-dock-top"></i>
                                        <div data-i18n="Account Settings">Account Settings</div>
                                    </a>
                                </li>
                            </ul>
                    </aside>
                     <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
                <nav
                        class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                        id="layout-navbar"
                    >
                        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                            </a>
                        </div>
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                            <!-- Search -->
                            <div class="navbar-nav align-items-center">
                                <div class="nav-item d-flex align-items-center">
                                     <i class="bx bx-search fs-4 lh-0"></i>
                                         <input
                                            type="text"
                                            class="form-control border-0 shadow-none"
                                            placeholder="Search..."
                                            aria-label="Search..."
                                        />
                                </div>
                            </div>
                            <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Place this tag where you want the button to render. -->
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="../assets-admin/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar avatar-online">
                                                            <img src="../assets-admin/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                                        </div>
                                                    </div>
                                                        <div class="flex-grow-1">
                                                            <span class="fw-semibold d-block">John Doe</span>
                                                            <small class="text-muted">Admin</small>
                                                        </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="auth-login-basic.html">
                                                <i class="bx bx-power-off me-2"></i>
                                                <span class="align-middle">Log Out</span>
                                            </a>
                                        </li>
                                    </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>
                        <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                            <!-- Content -->
                            <div class="container-xxl flex-grow-1 container-p-y">
                                <div class="row">
                                    <div class="col-lg-8 mb-4 order-0">
                                        <div class="card">
                                            <div class="d-flex align-items-end row">
                                                <div class="col-sm-7">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-primary">Congratulations John! 🎉</h5>
                                                            <p class="mb-4">
                                                                You have done <span class="fw-bold">72%</span> more sales today. Check your new badge in
                                                                your profile.
                                                            </p>
                                                            <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5 text-center text-sm-left">
                                                    <div class="card-body pb-0 px-0 px-md-4">
                                                        <img
                                                        src="../assets-admin/img/illustrations/man-with-laptop-light.png"
                                                        height="140"
                                                        alt="View Badge User"
                                                        data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                                        data-app-light-img="illustrations/man-with-laptop-light.png"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         <!-- / Content -->

                        <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                         <div class="mb-2 mb-md-0">
                            ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                                , made with ❤️ by
                            <a href="" target="_blank" class="footer-link fw-bolder">Randi</a>
                         </div>
                        </div>
                    </footer>
                        <!-- / Footer -->
                </div>
                <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>
    </div>
    <!-- / Layout wrapper -->
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{asset('assets-admin/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('assets-admin/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('assets-admin/vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('assets-admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('assets-admin/vendor/js/menu.js')}}"></script>
    <!-- endbuild -->
    <!-- Vendors JS -->
    <script src="{{asset('assets-admin/vendor/libs/apex-charts/apexcharts.js')}}"></script>
    <!-- Main JS -->
    <script src="{{asset('assets-admin/js/main.js')}}"></script>
    <!-- Page JS -->
    <script src="{{asset('assets-admin/js/dashboards-analytics.js')}}"></script>
</body>
</html>
