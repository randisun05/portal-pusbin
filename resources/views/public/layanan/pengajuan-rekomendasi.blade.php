@extends('layout.main-main')
@section('container')
@include('layout.web.nav')

<main>
    @include('layout.web.header-detail')
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

        <p>Adapun tujuan dari rekomendasi kebutuhan JFK diantaranya:</p>
        <ul>
            <li>Sebagai syarat pengusulan Uji Kompetensi</li>
            <li>Sebagai syarat perubahan nomenklatur</li>
            <li>Sebagai bagian pengangkatan dan pengembangan karier</li>
            <li>Pengisian volume beban kerja berdasarkan indikator yang sudah ditetapkan</li>
            <li>Rekomendasi yang diberikan sebanding dengan jumlah kebutuhan per jenjang, unit kerja penempatan, dan peta jabatan</li>
        </ul>
    </div>


 </div>


</main>


@include('layout.web.footer')
@endsection
