<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Direktorat Jabatan Fungsional Manajemen Aparatur Sipil Negara | Badan Kepegawaian Negara')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ asset('assets-flexor/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets-flexor/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets-flexor/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-flexor/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-flexor/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-flexor/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-flexor/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS Files -->
    <link href="{{ asset('assets-flexor/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-flexor/css/custom-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-flexor/css/skeleton.css') }}" rel="stylesheet">

    @stack('styles')

    <!-- =======================================================
    * Template Name: Flexor
    * Template URL: https://bootstrapmade.com/flexor-free-multipurpose-bootstrap-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body class="@yield('bodyClass', '')">

    {{-- Skeleton loading menggantikan preloader spinner bawaan template; beranda punya bentuk sendiri --}}
    @include('layout.partial.skeleton', ['variant' => trim(View::yieldContent('bodyClass')) === 'index-page' ? 'landing' : 'public'])

    @include('layout.partial.notif')

    @yield('container')

    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets-flexor/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets-flexor/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets-flexor/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets-flexor/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets-flexor/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets-flexor/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets-flexor/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets-flexor/js/main.js') }}"></script>
    <script src="{{ asset('assets-flexor/js/skeleton.js') }}"></script>

    @stack('scripts')

    @hasSection('noChat')
    @else
        @include('layout.partial.chat-widget')
    @endif

</body>

</html>
