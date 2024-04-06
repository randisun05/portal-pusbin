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

 <div class="team-details-area pt-120 mb-55" >
    <div class="container"  style="text-align:justify;text-justify: ">
    <p>Badan Kepegawaian Negara (BKN) selaku instansi Pembina Jabatan Fungsional Kepegawaian (JFK) DAN Pusat Pembinaan Jabatan Fungsional Kepegawaian (Pusbin JFK) selaku unit Pembina Jabatan Fungsional bidang Kepegawaian di BKN, menyelenggarakan uji kompetensi bagi PNS yang akan diangkat menjadi Pejabat Fungsional bidang Kepegawaian semua jenjang, melalui mekanisme perpindahan jabatan dari jabatan lain atau kenaikan jenjang jabatan.</p>
    <p>Pelaksanaan Uji Kompetensi diselenggarakan oleh Badan Kepegawaian Negara 4 (empat) periode dalam 1 (satu) tahun :</p>
    <p class="mb-0">1.	Periode I pada bulan Februari tahun berjalan, surat usulan dari instansi paling lambat diterima akhir Desember tahun sebelumnya; </p>
    <p class="mb-0">2.	Periode II pada bulan April tahun berjalan, surat usulan dari instansi paling lambat diterima akhir Februari tahun berjalan;</p>
    <p class="mb-0">3.	Periode III pada bulan Juli tahun berjalan, surat usulan dari instansi paling lambat diterima akhir Mei tahun berjalan; dan </p>
    <p class="mb-0">4.	Periode IV pada bulan Oktober tahun berjalan, surat usulan dari instansi paling lambat diterima akhir Agustus tahun berjalan.</p>
    <p>Penyelenggaraan Uji Kompetensi Jabatan Fungsional bidang Kepegawaian akan dilaksanakan dengan ketentuan, persyaratan dan jadwal sebagaimana Surat Edaran Deputi Pembinaan Manajemen Kepegawaian yang akan diumumkan disetiap periodenya.</p>
    <p><a href="{{asset('dokumen/ukomoktober.pdf')}}">Surat Deputi Pelaksanaan Uji Kompetensi Jabatan Fungsional Kepegawaian</a></p>
    </div>


</div>



</main>


@include('layout.web.footer')
@endsection
