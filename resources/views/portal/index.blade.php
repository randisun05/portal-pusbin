@extends('layout.main-main')

@section('container')

<!-- Navbar  -->
@include('layout.web.nav')
<main>
    @include('layout.web.header')
    @include('layout.web.data')
    @include('layout.web.show')
    @include('layout.web.berita')
    @include('layout.web.kegiatan')
    @include('layout.web.layanan')
</main>
@include('layout.web.footer')




@endsection
