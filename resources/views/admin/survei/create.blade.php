@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Tambah Survei Baru</h1>
        @if (session()->has('success'))
            <div class="alert alert-success col-lg-8" role="alert">
            {{session('success')}}
            </div>
        @endif

    <!-- Main Content -->

    <div class="card shadow">
        <div class="card-body">
            <form class="survei" action="/admin/survei/" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group mt-4 ms-5">
                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="nama">Nama Survei</label></div>
                    <div class="col"> <input type="text" class="form-control" @error('title') is-invalid @enderror name="title" id="title"
                    value="{{old('title')}}" placeholder="Masukan Nama Survei"></div>
                    @error('title')
                    <div class="invalid-feedback">
                      Masukan Nama Survei
                    </div>
                    @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                    <div class="col col-lg-2"><label for="type">Tipe Penilaian</label></div>
                    <div class="col">
                        <select class="form-select @error('type') is-invalid @enderror" name="type" id="type">
                            <option value="" disabled selected>Pilih Tipe Penilaian</option>
                            <option value="1">Teks</option>
                            <option value="2">Ya/Tidak</option>
                            <option value="3">Skala Penilaian 3</option>
                            <option value="4">Skala Penilaian 4</option>
                        </select>
                        @error('type')
                        <div class="invalid-feedback">
                            Masukan Tipe Penilaian
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col text-center m-3">
                    <button class="btn btn-lg btn-primary mt-3" type="submit">Simpan</button>
                    <a href="/admin/survei" class="btn btn-lg btn-primary ms-4 mt-3">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->


@endsection
