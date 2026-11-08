@extends('layout.main-admin')

@section('container')

 <!-- Begin Page Content -->
 <div class="container-fluid mt-5">
    <!-- Page Heading -->
    <h1 class="mb-2 text-center">Preview Publikasi</h1>
    <hr>
    <div class="mb-3">
        <a href="/admin/publikasi" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
        <a href="/admin/publikasi/{{ $post->id }}/edit" class="btn btn-warning"><i class="fas fa-edit"></i> Ubah</a>
        <form action="/admin/publikasi/{{ $post->id }}" method="POST" class="d-inline">
            @method('delete')
            @csrf
            <button class="btn btn-danger" onclick="return confirm('Lanjutkan Menghapus Publikasi')"><i class="fas fa-trash me-2"></i>Hapus</button>
        </form>
    </div>


    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
     {{ session('success') }}
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif


    <!-- Main Content -->
    <div class="card shadow">
        <div class="card-body">
            <h1>{{ $post->title }}</h1>
            <div><i class="fas fa-user me-2"></i><a href="/author/{{ $post->author->username }}" class="text-decoration-none">{{ $post->author->name }}</a></div>
            <div><i class="far fa-calendar-alt me-2"></i>{{ $post->publish_at }}</div>
            <div class="text-center">
                <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid" style="max-width: 50%">
            </div>
            <br>
            <div style="text-align:justify;text-justify: ">
                {!! $post->body !!}

                @if ($post->document)
                    <div class="mt-3">
                        Unduh Dokumen <a href="{{ asset('storage/' . $post->document) }}"
                            download="{{ $post->namadocument }}">Disini</a>
                    </div>
                @endif
        </div>
    </div>
</div>





<!-- End of Main Content -->

@endsection


    {{-- <div class="container-fluid">
        <div class="mb-3">
            <a href="/admin/publikasi" class="btn btn-secondary">Kembali</a>
            <a href="/admin/publikasi/{{ $post->id }}/edit" class="btn btn-warning"></box-icon> Ubah</a>
            <form action="/admin/publikasi/{{ $post->id }}" method="POST" class="d-inline">
                @method('delete')
                @csrf
                <button class="btn btn-danger" onclick="return confirm('Lanjutkan Menghapus Publikasi')">Hapus</button>
            </form>
        </div>

        <h2>{{ $post->title }}</h2>
        <p>By. <a href="/author/{{ $post->author->username }}" class="text-decoration-none">{{ $post->author->name }}</a> In
            <a href="/categories/{{ $post->category->slug }}"> {{ $post->category->name }} </p></a>
        <div class="text-center">
            <img src="{{ asset('storage/' . $post->image) }}" class="mg-fluid">
        </div>
        <br>
        <div style="text-align:justify;text-justify: ">
            {!! $post->body !!}

            @if ($post->document)
                <div class="mt-3">
                    Unduh Dokumen <a href="{{ asset('storage/' . $post->document) }}"
                        download="{{ $post->namadocument }}">Disini</a>
                </div>
            @endif

        </div>
    </div>

@endsection --}}
