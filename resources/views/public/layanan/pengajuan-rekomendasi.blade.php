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
 <div class="team-details-area pt-120 mb-55">

    <div class="container" style="text-align:justify;text-justify: " >
        <p>Untuk mewujudkan kesesuaian jumlah Jabatan Fungsional Kepegawaian (JFK) dengan beban kerja dan kebutuhan organisasi pada instansi pemerintah, diperlukan pedoman saat melakukan penyusunan kebutuhan JFK. Pedoman penyusunan kebutuhan Jabatan Fungsional Kepegawaian ini menjadi acuan bagi instansi pembina dan instansi pengguna dalam menyusun kebutuhan setiap jabatan fungsional Kepegawaiannya berdasarkan jenjang jabatannya. Secara teknis, ada 4 (empat) tahapan yang harus dilakukan saat penyusunan kebutuhan JFK sesuai Peraturan BKN, yakni mulai dari (1)Menyusun Standar Kebutuhan Rata-rata (SKR) dan Persentase Kontribusi, (2)Penghitungan Volume Beban Kerja, (3)Penghitungan Kebutuhan, dan (4)Penyusunan Peta Jabatan.</p>
        <p>Berikut dokumen pedoman penyusunan kebutuhan Jabatan Fungsional Kepegawaian berdasarkan jabatan fungsional : </p>
        <p class="mb-0">Analis Sumber Daya Manusia Aparatur</p>
        <p><a href="{{asset('dokumen/perbknno2thn2022.pdf')}}">Peraturan BKN No. 2 Tahun 2022 </a></p>
        <p class="mb-0">Pranata Sumber Daya Manusia Aparatur</p>
        <p><a href="{{asset('dokumen/perbknno3thn2022.pdf')}}">Peraturan BKN No. 3 Tahun 2022</a></p>
        <p class="mb-0">Asesor Sumber Daya Manusia Aparatur</p>
        <p><a href="{{asset('dokumen/perbknno4thn2022.pdf')}}">Peraturan BKN No. 3 Tahun 2022</a></p>

        <p>Adapun tujuan dari rekomendasi kebutuhan JFK diantaranya : </p>
        <p class="mb-0">-	Sebagai syarat pengusulan Uji Kompetensi</p>
        <p class="mb-0">-	Sebagai syarat perubahan nomenklatur</p>
        <p class="mb-0">-	Sabagai bagian pengangkatan dan pengembangan karier</p>
        <p class="mb-0">-	Pengisian volume beban kerja berdasarkan indicator yang sudah ditetapkan</p>
        <p class="mb-0">-	Rekomendasi yang diberikan sebanding dengan jumlah kebutuhan per jenjang, unit kerja penempatan, dan peta jabatan</p>
    </div>


 </div>


</main>


@include('layout.web.footer')
@endsection
