@extends('layout.main-main')
@section('container')
@include('layout.partial.header-componen')
@include('sweetalert::alert')

@if (session()->has('success'))
                            <div class="alert alert-success col-lg-8" role="alert">
                            {{session('success')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

@include('sweetalert::alert')




<div class="text-center mt-5 py-5">
<p>No Tiket Konsultasi Anda </p>
<p> <h1>{{$tiket}}</h1></p>
<p>Tiket Dijawab kurang lebih 2 hari, Cek Jawaban Konsultasi <a href="/konsultasi/cari">di sini</a></p>
<p><a href="/konsultasi">Kembali</a></p>

</div>
<div class="padingfooter mt-3">
@include('layout.partial.footer')
</div>
@endsection
