<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Pusat Pembinaan Jabatan Fungsional | Badan Kepegawaian Negara </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset ('assets/img/logo/favicon.png') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap">
    <!-- CSS here -->
    <link rel="stylesheet" href="{{asset ('assets/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset ('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{asset ('assets/css/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{asset ('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{asset ('assets/css/font-awesome-pro.css') }}">
    <link rel="stylesheet" href="{{asset ('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{asset ('assets/css/spacing.css') }}">
    <link rel="stylesheet" href="{{asset ('assets/css/ion.rangeSlider.min.css') }}">
    <link rel="stylesheet" href="{{asset ('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{asset ('assets/css/modern-theme.css') }}">

</head>

<body>
    <!-- preloader -->
    <div id="preloader" class="tp-preloader">
        <div id="loader-img" class="tp-preloader-img">
            <div class="tp-preloader-main" id="loader"></div>
        </div>
        <div id="tp-preloader-panel_left" class='tp-preloader-section tp-preloader-section-left'></div>
        <div id="tp-preloader-panel_right" class='tp-preloader-section tp-preloader-section-right'></div>
    </div>
    <!-- preloader end  -->
    <div class="back-to-top-wrapper">
        <button id="back_to_top" type="button" class="back-to-top-btn">
            <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 6L6 1L1 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
    </div>



    @yield('container')


    <script src="{{asset ('assets/js/vendor/jquery.js') }}"></script>
    <script src="{{asset ('assets/js/vendor/waypoints.js') }}"></script>
    <script src="{{asset ('assets/js/bootstrap-bundle.js') }}"></script>
    <script src="{{asset ('assets/js/meanmenu.js') }}"></script>
    <script src="{{asset ('assets/js/swiper-bundle.js') }}"></script>
    <script src="{{asset ('assets/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{asset ('assets/js/magnific-popup.js') }}"></script>
    {{-- <script src="{{asset ('assets/js/nice-select.js') }}"></script> --}}
    <script src="{{asset ('assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{asset ('assets/js/one-page-nav-min.js') }}"></script>
    <script src="{{asset ('assets/js/wow.js') }}"></script>
    <script src="{{asset ('assets/js/ajax-form.js') }}"></script>
    <script src="{{asset ('assets/js/main.js') }}"></script>

    @include('layout.partial.chat-widget')

</body>

</html>
