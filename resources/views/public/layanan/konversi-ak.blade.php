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

 <div style="text-align:justify;text-justify: " >
    <p>Dengan dilaksanakannya perubahan nomenklatur Jabatan Fungsional kepegawaian dan akan dialihkannya nomenklatur Jabatan Fungsional Kepegawaian ke dalam nomenklatur Analis Sumber Daya Manusia Aparatur, Pranata Sumber Daya Manusia Aparatur, Asesor Sumber Daya Manusia Aparatur, serta Auditor Manajemen Aparatur Sipil Negara sehingga perlu dilakukan perubahan Angka Kredit. Untuk kelancaran pelaksanaan perubahan Angka Kredit tersebut, ditetapkan Surat Edaran tentang Petunjuk Teknis Pelaksanaan Perubahan Angka Kredit dan Penetapan Pengangkatan Perubahan Nomenklatur Jabatan Fungsional Kepegawaian dan untuk batas waktu penyampaian daftar usul penetapan angka kredit (DUPAK) sesuai dengan surat yang telah dibuat oleh Kepala Pusat Pembinaan Jabatan Fungsional Kepegawaian.</p>
    <p class="mb-0">Hal ini dimuat dalam <a href="{{asset('dokumen/sebknno12thn2022.pdf')}}"> Surat Edaran Kepala BKN Nomor. 12 Tahun 2022 </a> dan <a href="{{asset('dokumen/suratbataswaktu.pdf')}}">Surat Batas Waktu Penyampaian Daftar Usul Penetapan Angka Kredit (DUPAK) Jabatan Fungsional Kepegawaian</a></p>
    <p>Adapun point-point perubahan angka kredit dan penetapan pengangkatan perubahan nomenklatur jabatan fungsional kepegawaian diantaranya :</p>
    <p class="mb-0">-	Berdasarkan periode penilaian PAK terakhir</p>
    <p class="mb-0">-	Periode penilaian PAK s.d 31 Desember 2021</p>
    <p class="mb-0">-	Pengusulan Penilaian Angka Kredit s.d 30 Juni 2022 atau 31 Desember 2021</p>
    <p class="mb-0">-	Penetapan Pengangkatan perubahan nomenklatur JFK s.d 31 Desember 2023</p>
    <p class="mb-0">-	Batas waktu pengusulan penilaian Angka Kredit sebagai dasar konversi 30 November 2022</p>
</div>


</main>


@include('layout.web.footer')
@endsection
