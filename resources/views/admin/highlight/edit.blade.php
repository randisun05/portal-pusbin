@extends('layout.main-admin')

@section('container')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Edit Highlight</h1>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
        {{session('success')}}
        </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow">

        <div class="card-body ">
            <form class="Highlight" action="/admin/highlight/{{$highlight->id}}" method="POST" enctype="multipart/form-data">
                @method('put')
                @csrf
              <div class="form-group mt-4 ms-5">
                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="nama">Nama Highlight</label></div>
                  <div class="col"> <input type="text" class="form-control" @error('nama') is-invalid @enderror name="name" id="name" value="{{old('name', $highlight->name)}}" placeholder="Masukan Nama Highlight"></div>
                  @error('name')
                  <div class="invalid-feedback">
                      Nama Highlight Harus Diisi
                  </div>
                  @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="desc">Descripsi Highlight</label></div>
                  <div class="col"> <input type="text" class="form-control" @error('desc') is-invalid @enderror name="desc" id="desc" value="{{old('desc', $highlight->desc)}}" placeholder="Masukan Deskripsi Highlight"></div>
                  @error('desc')
                  <div class="invalid-feedback">
                    Deskripsi Highlight Harus Diisi
                  </div>
                  @enderror
                </div>


                <div class="row row-cols-3 mb-4">
                    <div class="col col-lg-2"><label for="logo">Image</label></div>
                    <input type="hidden" name="oldImage" value="{{$highlight->image}}">
                    <div class="col"> <input type="file" class="form-control" @error('image') is-invalid @enderror name="image" id="image" placeholder="Masukan Image Highlight"></div>
                      @error('image')
                      <div class="invalid-feedback">
                        Please input Image Highlight.
                      </div>
                       @enderror
                      </div>
              </div>
              <div class='text-center'>
                <button class="btn btn-lg btn-primary mb-3" type="submit">Update Highlight</button>
                <a href="/admin/highlight" class="btn btn-lg btn-primary ms-3  mb-3">Batal</a>
              </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
