@extends('layout.main-main')
@section('container')
@include('layout.partial.header-componen')


<!-- Main Content -->
<div class="container py-5 px-lg-5">
    <article>
    <h2>{{$post->title}}</h2>
    <p>By. <a href="/publikasi?author={{$post->author->username}}" class="text-decoration-none">{{$post->author->name}}</a> In <a href="/publikasi?category={{$post->category->slug}}"> {{$post->category->name}} </p></a>

    <div class="text-center" >
        <img src="{{asset('storage/' . $post->image)}}" width="400px" class="mg-fluid">
    </div>
    <br>
    <div style="text-align:justify;text-justify: " >
        {!! $post->body !!}
        @if($post->namadocument)
        <div class="mt-3">
            Unduh Dokumen {{$post->namadocument}} <a href="{{ asset($post->document) }}">Disini</a>
        </div>
    @endif

    </div>
    </article>
</div>

<div class="text-center">
    <a href="/webpusbin" class="me-4"><u>Kembali</u></a> <a href="/publikasi"><u>Daftar Publikasi</u></a>
</div>

<!-- End Of Main Content -->

@include('layout.partial.footer')

@endsection
