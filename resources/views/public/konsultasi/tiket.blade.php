@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.partial.notif')

<main>
@include('layout.web.header-detail')

<section class="section text-center">
    <p class="text-muted mb-1">No Tiket Konsultasi Anda</p>
    <h1 class="mb-3" style="color: var(--accent-color);">{{$tiket}}</h1>
    <p>Tiket dijawab kurang lebih 2 hari, cek jawaban konsultasi <a href="/konsultasi/cari">di sini</a></p>
    <a href="/konsultasi" class="btn btn-outline-secondary mt-2">Kembali</a>
</section>
</main>

@include('layout.web.footer')
@endsection
