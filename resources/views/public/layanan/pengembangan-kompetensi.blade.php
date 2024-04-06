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
        <p>Pengembangan Kompetensi bagi ASN diatur dalam UU No.5 Tahun 2014, Berdasarkan hal tersebut maka setiap ASN memiliki hak dan kesempatan yang sama dalam mengembangkan kompetensi. Pengembangan kompetensi untuk ASN dapat dilaksanakan melalui pendidikan dan pelatihan, seminar, kursus, dan penataran. Pengembangan kompetensi ASN selanjutnya diatur lebih lanjut melalui Peraturan Lembaga Administrasi Negara (PerLAN) Nomor 5 Tahun 2018 tentang Pengembangan Kompetensi Pegawai Aparatur Sipil Negara (ASN). Hal ini juga sejalan dengan Peraturan Lembaga Administrasi Negara Nomor 10 Tahun 2018 tentang Pengembangan Kompetensi Pegawai Negeri Sipil (PNS). Berdasarkan Peraturan LAN tersebut, pengembangan kompetensi melalui pelatihan terdiri atas pelatihan klasikal dan pelatihan non klasikal. Pelatihan klasikal merupakan proses pembelajaran tatap muka di dalam kelas dengan mengacu kurikulum. Pelatihan non klasikal merupakan proses praktik kerja dan / atau pembelajaran di luar kelas dan dilaksanakan melalui jalur pertukaran PNS dengan pegawai swasta; magang / praktik kerja; benchmarking atau study visit; pelatihan jarak jauh; coaching; mentoring; detasering; penugasan terkait program prioritas; e-learning; belajar mandiri/self-development; team building; dan jalur lain yang memenuhi ketentuan pelatihan non klasikal.</p>
        <p>PerLAN Nomor 5 Tahun 2018 juga mengatur tentang kewajiban setiap ASN untuk melaksanakan pengembangan kompetensi paling sedikit 20 (dua puluh) jam pelajaran dalam periode 1 (satu) tahun. Perhitungan 1 (satu) jam pelajaran setara dengan 45 (empat puluh lima) menit pembelajaran. Sehingga setiap instansi Pemerintah wajib menyusun rencana pengembangan kompetensi tahunan melalui rencana kerja anggaran tahunan instansi. Tentunya hal ini yang mendasari PPK untuk menetapkan kebutuhan dan rencana pengembangan kompetensi, melaksanakan pengembangan kompetensi serta melaksanakan evaluasi pengembangan kompetensi pegawai ASN.</p>
        <p>Pengembangan Kompetensi bagi pegawai jabatan fungsional kepegawaian sangat penting dilakukan untuk meningkatkan pemahaman dan wawasan seputar tugas-tugas jabatan fungsional kepegawaian, selain itu untuk melakukan update atau pembaharuan tentang keilmuan sumber daya manusia aparatur. </p>
    </div>

 </div>




</main>

@include('layout.web.footer')
@endsection
