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
    <title>Admin Direktorat JF MASN</title>
    <meta name="description" content="" />
    <!-- Favicon -->
    <link href="{{asset('assets/img/logo-pusbin.png')}}" rel="icon">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('assets-admin/vendor/fonts/boxicons.css')}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
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

    <link rel="stylesheet" type="text/css" href="{{ asset('assets-admin/vendor/trix/trix.css') }}">
  <script type="text/javascript" src="{{ asset('assets-admin/vendor/trix/trix.umd.min.js') }}"></script>




</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        @include('layout.partial.navside-admin')
          <!-- Layout container -->
          <div class="layout-page">
              @include('layout.partial.nav-admin')
                @yield('container')

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

