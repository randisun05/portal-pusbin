@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.web.header-detail')


<!-- Main Content -->
<div class="container-xxl py-5">
    <article>
        <h1>{{$post->title}}</h1>
        <div><i class="fas fa-user me-2"></i><a href="/author/{{ $post->author->username }}"
                class="text-decoration-none">{{ $post->author->name }}</a></div>
        <div><i class="far fa-calendar-alt me-2"></i>{{ $post->publish_at }}</div>

        <div class="text-center">
            <img src="{{asset('storage/' . $post->image)}}" class="mg-fluid" style="width: 50%">
        </div>
        <br>
        <div class="text-black" style="text-align:justify;text-justify: ">
            {!! $post->body !!}
            @if($post->document)
            <div class="mt-3">
                Unduh Dokumen {{$post->namadocument}} <a href="/storage/{{ $post->document }}"
                    download="{{$post->namadocument}}">Disini</a>
            </div>
            @endif
        </div>
    </article>
</div>

<div class="text-center">
    <a href="/webpusbin" class="me-4"><u>Kembali</u></a> <a href="/publikasi"><u>Daftar Publikasi</u></a>
</div>

<!-- End Of Main Content -->

@include('layout.web.footer')

@endsection
