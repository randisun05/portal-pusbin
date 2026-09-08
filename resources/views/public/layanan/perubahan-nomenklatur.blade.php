@extends('layout.main-main')
@section('container')
@include('layout.web.nav')

<main>
    @include('layout.web.header-detail')

    <div class="container py-5 px-lg-5" style="text-align:justify;text-justify: ">
        <p>Dengan telah ditetapkannya Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 37 tahun 2020 tentang Jabatan Fungsional Analis Sumber Daya Manusia Aparatur, Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 38 tahun 2020 tentang Jabatan Fungsional Pranata Sumber Daya Manusia Aparatur, Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 39 tahun 2020 tentang Jabatan Fungsional Asesor Sumber Daya Manusia Aparatur, dan Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 94 tahun 2020 tentang Jabatan Fungsional Auditor Manajemen Aparatur Sipil Negara, untuk kelancaran pelaksanaan tugas jabatannya perlu diterbitkan Surat Edaran Kepala Badan Kepegawaian Negara tentang Perubahan Nomenklatur Jabatan Fungsional Kepegawaian.</p>

        <p>Hal ini tercantum dalam <a href="{{ asset('dokumen/sebknno11thn2022.pdf') }}">Surat Edaran Kepala BKN Nomor. 11 Tahun 2022</a></p>

        <p>Adapun point-point perubahan nomenklatur diantaranya:</p>
        <ul>
            <li>Ditetapkan dengan keputusan pengangkatan</li>
            <li>Mencantumkan Angka Kredit Konversi</li>
            <li>Masa Peralihan sampai dengan 31 Desember 2023</li>
            <li>Pemberlakuan Kelas Jabatan Baru</li>
            <li>Penetapan Tunjangan Jabatan Baru</li>
        </ul>
    </div>
</main>

@include('layout.web.footer')
@endsection
