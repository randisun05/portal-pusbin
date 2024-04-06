@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
<main>

@include('layout.web.header-detail')

    <!-- team-details-area-start -->
    <div class="team-details-area pt-120 mb-55">
        <div class="container">
            <div class="row gx-0">
                <div class="offset-xl-1 col-xl-4 col-lg-5 h-100">
                    <div class="tp-team-details-thumb tp-thumb">
                        <div class="tp-thumb-overlay wow"></div>
                        <img class="w-100" src="{{asset ('assets/img/team/team-thumb.jpg') }}" alt="team">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="tp-team-details-content h-100">
                        <h3 class="tp-team-details-title">Dr. Achmad Slamet Hidayat, S.Pd., M.Si.</h3>
                        <span class="tp-team-details-subtitle">Kepala Pusat Pembinaan Jabatan Fungsional Kepegawaian</span>
                        <p>This is the main factor that sets us apart from our competition and allows us to deliver a specialist business consultancy service</p>
                        <div class="tp-team-details-list">
                            <p><b>Responsibility:</b><a href="#">Consultant</a></p>
                            <p><b>Email Address:</b><a href="#">needhelp@gmail.com</a></p>
                            <p><b>Phone Number:</b><a href="#">+1 888 098-90987</a></p>
                            <p><b>Web Address:</b><a href="#"> www.yourdomain.com</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- team-details-area-end -->
</main>


@include('layout.web.footer')

@endsection
