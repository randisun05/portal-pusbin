 <!-- Navbar & Hero Start -->
 <div class="container-fluid position-relative p-0">
    @include('layout.partial.nav')

    <!-- Header Componen -->
    <div class="py-2 bg-primary hero-header">
        <div class="container my-5 py-2 px-lg-5">
            <div class="row g-5 mt-4">
                <div class="col-12 text-center">
                    <h1 class="text-white animated slideInDown">{{ !empty($title) ? $title : 'Halaman Dalam Pengembangan' }}</h1>
                    <hr class="bg-white mx-auto mt-0" style="width: 90px;">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Navbar & Hero End -->
