@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Tambah FAQ Baru</h1>
    @if (session()->has('success'))
    <div class="alert alert-success col-lg-8" role="alert">
        {{session('success')}}
    </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow">
        <div class="card-body">
            <form action="/admin/faq" method="POST">
                @csrf
                <div class="form-group mt-4 ms-5">
                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="pertanyaan">Pertanyaan</label></div>
                        <div class="col"> <input type="text" class="form-control" @error('pertanyaan') is-invalid @enderror
                                name="pertanyaan" id="pertanyaan" value="{{old('pertanyaan')}}" placeholder="Masukan Pertanyaan">
                        </div>
                        @error('pertanyaan')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="jawaban">Jawaban</label></div>
                        <div class="col"> <textarea class="form-control" @error('jawaban') is-invalid @enderror
                                name="jawaban" id="jawaban" rows="4" placeholder="Masukan Jawaban">{{old('jawaban')}}</textarea>
                        </div>
                        @error('jawaban')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="kategori">Kategori</label></div>
                        <div class="col"> <input type="text" class="form-control" @error('kategori') is-invalid @enderror
                                name="kategori" id="kategori" value="{{old('kategori')}}" placeholder="Contoh: Konsultasi, Uji Kompetensi (opsional)">
                        </div>
                        @error('kategori')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="urutan">Urutan Tampil</label></div>
                        <div class="col"> <input type="number" class="form-control" @error('urutan') is-invalid @enderror
                                name="urutan" id="urutan" value="{{old('urutan', 0)}}">
                        </div>
                        @error('urutan')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col text-center m-3">
                        <button class="btn btn-lg btn-primary mt-3" type="submit">Simpan</button>
                        <a href="/admin/faq" class="btn btn-lg btn-primary ms-4 mt-3">Batal</a>
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
