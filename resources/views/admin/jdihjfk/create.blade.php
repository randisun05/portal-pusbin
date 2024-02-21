@extends('layout.main-admin')

@section('container')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Tambah JDIH JFK Baru</h1>
        @if (session()->has('success'))
            <div class="alert alert-success col-lg-8" role="alert">
            {{session('success')}}
            </div>
        @endif

    <!-- Main Content -->

    <div class="card shadow">
        <div class="card-body">
            <form class="jdihjfk" action="/admin/jdihjfk/" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group mt-4 ms-5">
                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="nama">Nama Peraturan</label></div>
                    <div class="col"> <input type="text" class="form-control" @error('title') is-invalid @enderror name="title" id="title"
                    value="{{old('title')}}" placeholder="Masukan Nama Peraturan"></div>
                    @error('title')
                    <div class="invalid-feedback">
                      Masukan Nama Peraturan
                    </div>
                    @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="desc">Descripsi Peraturan</label></div>
                  <div class="col"> <input type="text" class="form-control" @error('deskripsi') is-invalid @enderror name="deskripsi" id="deskripsi"
                    value="{{old('deskripsi')}}" placeholder="Masukan Deskripsi Peraturan"></div>
                    @error('deskripsi')
                    <div class="invalid-feedback">
                        Masukan Deskripsi Peraturan
                    </div>
                    @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="link">Link Peraturan</label></div>
                  <div class="col"> <input type="text" class="form-control" @error('link') is-invalid @enderror name="link" id="link"
                    value="{{old('link')}}" placeholder="Masukan Link Peraturan"></div>
                    @error('link')
                    <div class="invalid-feedback">
                        Masukan Link Peraturan
                    </div>
                    @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="image">image</label></div>
                  <div class="col"> <input type="file" class="form-control" @error('image') is-invalid @enderror name="image" id="image"
                    placeholder="Masukan image Peraturan"></div>
                    @error('image')
                    <div class="invalid-feedback">
                        Masukan Image Peraturan.
                    </div>
                     @enderror
                </div>
              </div>
              <div class="col text-center m-3">
                <button class="btn btn-lg btn-primary mt-3" type="submit">Simpan</button>
                <a href="/admin/jdihjfk" class="btn btn-lg btn-primary ms-4 mt-3">Batal</a>
              </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->


@endsection
