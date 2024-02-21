@extends('layout.main-admin')

@section('container')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Edit Indikator</h1>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
        {{session('success')}}
        </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow">

        <div class="card-body ">
            <form class="Layanan" action="/admin/surveiindikator/{{$data->id}}" method="POST" enctype="multipart/form-data">
                @method('put')
                @csrf
              <div class="form-group mt-4 ms-5">
                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="nama">Nama Indikator</label></div>
                  <div class="col"> <input type="text" class="form-control" @error('title') is-invalid @enderror name="title" id="title" value="{{old('title', $data->title)}}" placeholder="Masukan Nama Indikator"></div>
                  @error('nama')
                  <div class="invalid-feedback">
                      Nama Survei Harus Diisi
                  </div>
                  @enderror
                </div>
              </div>
              <div class='text-center'>
                <button class="btn btn-lg btn-primary mb-3" type="submit">Update Indikator</button>
                <a href="/admin/surveiindikator" class="btn btn-lg btn-primary ms-3  mb-3">Batal</a>
              </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
