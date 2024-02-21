@extends('layout.main-main')
@section('container')
@include('layout.partial.header-componen')
<div class="container py-5 px-lg-5">
    <article>
        <h2 class="text-center mb-4">REKOMENDASI KEBUTUHAN</h2>
        <div style="text-align:justify;text-justify: " >
            <p>Dengan telah ditetapkannya Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 37 tahun 2020 tentang Jabatan Fungsional Analis Sumber Daya Manusia Aparatur, Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 38 tahun 2020 tentang Jabatan Fungsional Pranata Sumber Daya Manusia Aparatur, Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 39 tahun 2020 tentang Jabatan Fungsional Asesor Sumber Daya Manusia Aparatur, dan Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 94 tahun 2020 tentang Jabatan Fungsional Auditor Manajemen Aparatur Sipil Negara, untuk kelancaran pelaksanaan tugas jabatannya perlu diterbitkan Surat Edaran Kepala Badan Kepegawaian Negara tentang Perubahan Nomenklatur Jabatan Fungsional Kepegawaian.</p>

            <p>Hal ini tercantum dalam <a href="{{asset('dokumen/sebknno11thn2022.pdf')}}">Surat Edaran Kepala BKN Nomor. 11 Tahun 2022</a></p>

            <p>Adapun point-point perubahan nomenklatut diantaranya :</p>
            <p class="mb-0">-	Ditetapkan dengan keputusan pengangkatan</p>
            <p class="mb-0">-	Mencantumkan Angka Kredit Konversi </p>
            <p class="mb-0">-	Masa Peralihan sampai dengan 31 Desember 2023</p>
            <p class="mb-0">-	Pemberlakuan Kelas Jabatan Baru</p>
            <p class="mb-0">-	Penetapan Tunjangan Jabatan Baru</p>
    </article>
</div>
@include('layout.partial.footer')
@endsection
