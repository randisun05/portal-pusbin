@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
<main>
     <!-- breadcrumb-area-start -->
     <div class="tp-breadcrumb-area-7 bg-position-default" data-background="{{asset ('assets/img/breadcrumb/breadcrumb-bg8.jpg') }}">
        <div class="container-fluid">
           <div class="row">
            <div class="col-lg-12">
                <div class="tp-breadcrumb-list-5 pt-200 pb-185 text-center wow fadeInUp" data-wow-delay=".3s" data-wow-duration="1s">
                    <h2 class="tp-breadcrumb-title-2 mb-20">{{ $title }}</h2>
                    <div class="tp-breadcrumb-list-inner-2">
                       <span><a href="index.html">Beranda </a></span>
                       <span class="tp-breadcrumb-dvdr"> /</span>
                       <span>{{ $title }}</span>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </div>
     <!-- breadcrumb-area-end -->

    <div class="container-fluid py-5">
        <div class="container py-5 px-lg-5">
            <div class="wow fadeInUp" data-wow-delay="0.1s">
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">

                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item bg-light rounded">
                        <div class="text-center border-bottom p-4">
                            <img class="img-fluid rounded-circle mb-4" src="/assets/img/kapus.png" alt=""
                                style="width: 60%">
                            <h5>Dr. Achmad Slamet Hidayat, S.Pd., M.Si.</h5>
                            <span>Kepala Pusbin JFK</span>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">

                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item bg-light rounded">
                        <div class="text-center border-bottom p-4">
                            <img class="img-fluid rounded-circle mb-4" src="/assets/img/sarni.png" alt=""
                                style="width: 60%">
                            <h5>Sarni, S.E.</h5>
                            <span>Analis SDM Aparatur Ahli Madya</span>
                            <div>
                                <span>Ketua Pokja 1</span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item bg-light rounded">
                        <div class="text-center border-bottom p-4">
                            <img class="img-fluid rounded-circle mb-4" src="/assets/img/agung.png" alt=""
                                style="width: 60%">
                            <h5>Agung Sugiarto, S.H., M.H.</h5>
                            <span>Analis SDM Aparatur Ahli Madya</span>
                            <div>
                                <span>Ketua Pokja 2</span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item bg-light rounded">
                        <div class="text-center border-bottom p-4">
                            <img class="img-fluid rounded-circle mb-4" src="/assets/img/tauchid.png" alt=""
                                style="width: 60%">
                            <h5>Tauchid Djatmiko, S.H., M.Si.</h5>
                            <span>Analis SDM Aparatur Ahli Utama</span>
                            <div>
                                <span>Ketua Pokja 3</span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item bg-light rounded">
                        <div class="text-center border-bottom p-4">
                            <img class="img-fluid rounded-circle mb-4"src="/assets/img/elin.png" alt=""
                                style="width: 60%">
                            <h5>Dr. Elin Cahyaningsih, S.Kom., MMSI.</h5>
                            <span>Analis SDM Aparatur Ahli Madya</span>
                            <div>
                                <span>Ketua Pokja 4</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include('layout.web.footer')

@endsection
