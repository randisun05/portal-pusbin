@extends('layout.main-main')
@section('container')
@include('layout.partial.header-componen')

<div class="container py-5 px-lg-5">
    <article>
        <h2 class="text-center mb-4">PENGUSULAN PENETAPAN ANGKA KREDIT</h2>
        <div style="text-align:justify;text-justify: " >
            <p>Pengusulan penetapan angka kredit (PAK) adalah proses Pengusulan penetapan angka kredit kepada pejabat yang berwenang menetapkan angka kreditAngka Kredit adalah satuan nilai dari uraian kegiatan dan/atau akumulasi nilai dari uraian kegiatan yang harus dicapai oleh Pejabat Fungsional dalam rangka pembinaan karier yang bersangkutan.</p>
            <p>Berikut Alur proses pengajuan PAK : </p>
            <div class="text-center">
            <img src="{{asset('img/alurpak.jpg')}}" alt="">
            </div>

    </article>
</div>
@include('layout.partial.footer')
@endsection
