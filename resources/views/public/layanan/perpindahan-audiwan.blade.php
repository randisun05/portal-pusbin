@extends('layout.main-main')
@section('container')
@include('layout.web.nav')

<main>
    @include('layout.web.header-detail')

    <div class="team-details-area pt-120 mb-55">
        <div class="container" style="text-align:justify;text-justify: ">
            <p>Berdasarkan Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 94 Tahun 2020 tentang Jabatan Fungsional Auditor Manajemen Aparatur Sipil Negara, ditentukan bahwa Auditor Kepegawaian berubah menjadi Auditor Manajemen Aparatur Sipil Negara (Auditor Manajemen ASN) dan berkedudukan sebagai pelaksana teknis di bidang Audit Manajemen ASN pada Badan Kepegawaian Negara (tertutup). Kemudian dalam Surat Kepala Badan Kepegawaian Negara Nomor: 3475/B-BJ.02.02/SD/K/2021 tanggal 16 April 2021 tentang Pembinaan Jabatan Fungsional Auditor Kepegawaian diatur bahwa Auditor Kepegawaian di luar Badan Kepegawaian Negara mengajukan perpindahan ke Jabatan Fungsional Kepegawaian lain atau Jabatan Fungsional lainnya. Untuk kelancaran pelaksanaan perpindahan Jabatan Fungsional Auditor Kepegawaian ke dalam Jabatan Fungsional lainnya, perlu diterbitkan Surat Edaran Kepala Badan Kepegawaian Negara tentang Tata Cara Perpindahan Jabatan Fungsional Auditor Kepegawaian Ke Dalam Jabatan Fungsional Lainnya.</p>
            <p>Hal ini sesuai dengan <a href="{{asset('dokumen/sebknno132022.pdf')}}">Surat Edaran Kepala BKN Nomor 13 Tahun 2022</a></p>
            <p>Adapun point-point perpindahan Jabatan Fungsional Audiwan ke Jabatan Fungsional lain diantaranya : </p>
            <p class="mb-0">- Perubahan Auditor Kepegawaian ke Auditor Manajemen ASN yang bersifat tertutup</p>
            <p class="mb-0">- Jenis: Perpindahan ke JFK lain & Perpindahan ke JF lain non JFK</p>
            <p class="mb-0">- Bagi ke JFK: Jenjang dan Angka Kredit sesuai dengan sebelumnya</p>
            <p class="mb-0">- Uji Kompetensi perpindahan ke JFK terakhir 28 September 2025</p>
            <p class="mb-0">- Pengangkatan ke JFK s.d 28 Desember 2025</p>
            <p class="mb-0">- Wajib pelaporan bagi perpindahan ke non JFK</p>
        </div>
    </div>



</main>


@include('layout.web.footer')
@endsection
