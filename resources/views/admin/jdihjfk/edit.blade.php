@extends('layout.main-admin')

@section('container')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Edit JDIF JFK</h1>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
        {{session('success')}}
        </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow">

        <div class="card-body ">
            <form class="Layanan" action="/admin/jdihjfk/{{$data->id}}" method="POST" enctype="multipart/form-data">
                @method('put')
                @csrf
              <div class="form-group mt-4 ms-5">
                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="nama">Nama Peraturan</label></div>
                  <div class="col"> <input type="text" class="form-control" @error('title') is-invalid @enderror name="title" id="title" value="{{old('title', $data->title)}}" placeholder="Masukan Nama Peraturan"></div>
                  @error('nama')
                  <div class="invalid-feedback">
                      Nama Peraturan Harus Diisi
                  </div>
                  @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="desc">Descripsi Peraturan</label></div>
                  <div class="col"> <input type="text" class="form-control" @error('deskripsi') is-invalid @enderror name="deskripsi" id="deskripsi" value="{{old('deskripsi', $data->deskripsi)}}" placeholder="Masukan Deskripsi Peraturan"></div>
                  @error('deskripsi')
                  <div class="invalid-feedback">
                    Deskripsi Peraturan Harus Diisi
                  </div>
                  @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="link">Link Peraturan</label></div>
                  <div class="col"> <input type="text" class="form-control" @error('link') is-invalid @enderror name="link" id="link" value="{{old('link', $data->link)}}" placeholder="Masukan Link Peraturan"></div>
                  @error('link')
                  <div class="invalid-feedback">
                    Link Peraturan Harus Diisi
                  </div>
                  @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                    <div class="col col-lg-2"><label for="logo">Image</label></div>
                    <input type="hidden" name="oldImage" value="{{ $data->image}}">
                    <div class="col"> <input type="file" class="form-control" @error('image') is-invalid @enderror name="image" id="image" placeholder="Masukan Image Peraturan"></div>
                      @error('image')
                      <div class="invalid-feedback">
                        Please input Image Peraturan
                      </div>
                       @enderror
                      </div>



              </div>
              <div class='text-center'>
                <button class="btn btn-lg btn-primary mb-3" type="submit">Update Peraturan</button>
                <a href="/admin/jdihjfk" class="btn btn-lg btn-primary ms-3  mb-3">Batal</a>
              </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
