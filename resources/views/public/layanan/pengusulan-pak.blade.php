@extends('layout.main-main')
@section('container')
@include('layout.web.nav')

<main>
    @include('layout.web.header-detail')

    <section class="section">
    <div class="container prose-content">
        <p>Pengusulan penetapan angka kredit (PAK) adalah proses pengusulan penetapan angka kredit kepada pejabat yang berwenang menetapkan angka kredit. Angka Kredit adalah satuan nilai dari uraian kegiatan dan/atau akumulasi nilai dari uraian kegiatan yang harus dicapai oleh Pejabat Fungsional dalam rangka pembinaan karier yang bersangkutan.</p>
        <p>Berikut alur proses pengajuan PAK:</p>
        <div class="text-center">
            <img src="{{ asset('assets/img/alurpak.jpg') }}" alt="Alur Pengusulan PAK" class="img-fluid">
        </div>
    </div>
    </section>
</main>

@include('layout.web.footer')
@endsection
