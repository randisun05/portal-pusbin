@extends('layout.main-main')
@section('container')
@include('layout.web.nav')

<main>
    @include('layout.web.header-detail')

 <div class="team-details-area pt-120 mb-55" >
    <div class="container"  style="text-align:justify;text-justify: ">
    <p>Badan Kepegawaian Negara (BKN) selaku instansi Pembina Jabatan Fungsional Kepegawaian (JFK) DAN Direktorat Jabatan Fungsional Manajemen Aparatur Sipil Negara (Direktorat JF MASN) selaku unit Pembina Jabatan Fungsional bidang Kepegawaian di BKN, menyelenggarakan uji kompetensi bagi PNS yang akan diangkat menjadi Pejabat Fungsional bidang Kepegawaian semua jenjang, melalui mekanisme perpindahan jabatan dari jabatan lain atau kenaikan jenjang jabatan.</p>
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
