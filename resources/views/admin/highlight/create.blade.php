@extends('layout.main-admin')

@section('container')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Tambah Highlight Baru</h1>
        @if (session()->has('success'))
            <div class="alert alert-success col-lg-8" role="alert">
            {{session('success')}}
            </div>
        @endif

    <!-- Main Content -->

    <div class="card shadow">
        <div class="card-body">
            <form class="Layanan" action="/admin/highlight/" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group mt-4 ms-5">
                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="name">Nama Hightlight</label></div>
                    <div class="col"> <input type="text" class="form-control" @error('name') is-invalid @enderror name="name" id="name"
                    value="{{old('name')}}" placeholder="Masukan Nama Hightlight"></div>
                    @error('name')
                    <div class="invalid-feedback">
                      Masukan Nama Hightlight
                    </div>
                    @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="desc">Descripsi Hightlight</label></div>
                  <div class="col"> <input type="text" class="form-control" @error('desc') is-invalid @enderror name="desc" id="desc"
                    value="{{old('desc')}}" placeholder="Masukan Deskripsi Hightlight"></div>
                    @error('desc')
                    <div class="invalid-feedback">
                        Masukan Deskripsi Hightlight
                    </div>
                    @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="link">Image Hightlight</label></div>
                  <div class="col"> <input type="file" class="form-control" @error('image') is-invalid @enderror name="image" id="image"
                    value="{{old('image')}}" placeholder="Masukan Image Hightlight"></div>
                    @error('image')
                    <div class="invalid-feedback">
                        Masukan Image Hightlight.
                    </div>
                    @enderror
                </div>
              <div class="col text-center m-3">
                <button class="btn btn-lg btn-primary mt-3" type="submit">Simpan</button>
                <a href="/admin/highlight" class="btn btn-lg btn-primary ms-4 mt-3">Batal</a>
              </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->


@endsection
