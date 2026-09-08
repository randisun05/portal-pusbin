@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.partial.notif')

<main>
@include('layout.web.header-detail')

<div class="text-center mt-5 py-5">
    <p>No Tiket Konsultasi Anda</p>
    <h1>{{$tiket}}</h1>
    <p>Tiket dijawab kurang lebih 2 hari, cek jawaban konsultasi <a href="/konsultasi/cari">di sini</a></p>
    <p><a href="/konsultasi">Kembali</a></p>
</div>
</main>

@include('layout.web.footer')
@endsection
