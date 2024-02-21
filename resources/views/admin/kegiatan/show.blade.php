@extends('layout.main-main')

@section('container')


<div class="container py-5 px-lg-5">
    <div class="mb-3">
        <a href="/admin/publikasi" class="btn btn-success">Kembali</a>
        <a href="/admin/publikasi/{{$post->id}}/edit" class="btn btn-success"></box-icon> Ubah</a>
            <form action="/admin/publikasi/{{$post->id}}" method="POST" class="d-inline">
                @method('delete')
                @csrf
                <button class="btn btn-success" onclick="return confirm('Lanjutkan Menghapus Publikasi')">Hapus</button>
            </form>
    </div>

    <h2>{{$post->title}}</h2>
    <p>By. <a href="/author/{{$post->author->username}}" class="text-decoration-none">{{$post->author->name}}</a> In <a href="/categories/{{$post->category->slug}}"> {{$post->category->name}} </p></a>
    <div class="text-center" >
    <img src="{{asset('storage/' . $post->image)}}" width="1000px" class="mg-fluid">
    </div>
    <br>
    <div style="text-align:justify;text-justify: " >
    {!! $post->body !!}
    <div class="mt-3">
        Unduh Dokumen {{$post->namadocument}} <a href="{{asset($post->document)}}">Disini</a>
    </div>
    </div>
</div>


@include('layout.partial.footer')

@endsection
