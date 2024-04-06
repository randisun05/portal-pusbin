@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.web.header-detail')
@include('layout.partial.notif')

<main>

    <div class="about-area p-relative p-overflow pt-115 pb-90">
        <div class="tp-about-left-shape-2 p-absolute"></div>
        <div class="container">
           <div class="row">
              <div class="col-lg-6">
                 <div class="tp-about-left-wrap-fin p-relative pb-30 wow fadeInLeft" data-wow-delay=".3s" data-wow-duration="1s">
                    <img class="tp-about-img-fin " src="{{asset ('assets/img/konsul2.png') }}" alt="01" width="100%">
                 </div>
              </div>
              <div class="col-lg-6">
                 <div class="tp-about-right-wrapper p-relative pb-30 wow fadeInRight" data-wow-delay=".3s" data-wow-duration="1s">
                    <div class="tp-section-title-wrapper mb-10">
                       <span class="tp-section-title-pre tp-section-title-pre4">Jangan Lewatkan</span>
                       <h2 class="tp-section-title">{{ $kegiatan->nama }}</h2>
                    </div>
                    <p class="mb-35">Middle removes the guesswork by organising and sharing all the information
                       your broker needs to recommend the best home loan for your situation.
                       Get your mortgage journey moving with less admin</p>
                    <div class="tp-about-list-fin mb-45">
                       <div class="tp-about-list d-flex align-items-center">
                          <div class="tp-about-list-icon tp-about-list-ico-fin">
                             <i class="flaticon-consulting"></i>
                          </div>
                          <div class="tp-about-list-iner-fin">
                             <h4 class="tp-about-title-fin">Consulting Business</h4>
                             <p class="tp-about-sub-tit-fin m-0">Your success is our mission. As<br> we offer expert guidance</p>
                          </div>
                       </div>
                    </div>
                    <div class="tp-about-contact tp-about-contact-fin d-flex align-items-center">
                       <div class="tp-btn-default">
                          <a class="tp-btn tp-btn-yellow" href="/kegiatan/{{ $kegiatan->slug }}/create">Rencana Hadir<i class="fa-solid fa-arrow-right"></i></a>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </div>
     <!-- about-area-end -->
</main>
<!-- Form Usulan Konsultasi -->



@include('layout.web.footer')


@endsection
