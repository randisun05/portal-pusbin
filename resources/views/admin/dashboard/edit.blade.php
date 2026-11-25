@extends('layout.main-admin')

@section('container')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Ubah Dashboard</h1>
        @if (session()->has('success'))
            <div class="alert alert-success col-lg-8" role="alert">
            {{session('success')}}
            </div>
        @endif

    <!-- Main Content -->

    <div class="card shadow">
        <div class="card-body">
            <form class="Dashboard" action="/admin/dashboard/{{ $dashboard->id }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('put')
              <div class="form-group mt-4 ms-5">
                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="nama">Nama Dashboard</label></div>
                    <div class="col"> <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama"
                    value="{{old('nama', $dashboard->nama)}}" placeholder="Masukan Nama Dashboard"></div>
                    @error('nama')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="desc">Deskripsi</label></div>
                  <div class="col"> <input type="text" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi"
                    value="{{old('deskripsi', $dashboard->deskripsi)}}" placeholder="Masukan Deskripsi Dashboard"></div>
                    @error('deskripsi')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="link">Link Dashboard</label></div>
                  <div class="col"> <input type="url" class="form-control @error('link') is-invalid @enderror" name="link" id="link"
                    value="{{old('link', $dashboard->link)}}" placeholder="Masukan Link Dashboard"></div>
                    @error('link')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="image">Gambar</label></div>
                  <div class="col"> <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image"
                    accept="image/*"> @if($dashboard->image)<div class="form-text">Gambar saat ini ada; pilih berkas baru untuk menggantinya.</div>@endif</div>
                    @error('image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                     @enderror
                </div>
              </div>

              <div class="col text-center m-3">
                <button class="btn btn-lg btn-primary mt-3" type="submit">Simpan</button>
                <a href="/admin/dashboard" class="btn btn-lg btn-primary ms-4 mt-3">Batal</a>
              </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->


@endsection
