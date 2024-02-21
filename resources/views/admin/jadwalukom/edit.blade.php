@extends('layout.main-admin')

@section('container')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Edit Jadwal Ujian Kompetensi</h1>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
        {{session('success')}}
        </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow">
      jadwal{{$jadwal->id}}
        <div class="card-body ">
            <form class="Jadwal" action="/admin/jadwalukom/{{$jadwal->id}}" method="POST" enctype="multipart/form-data">
                @method('put')
                @csrf
              <div class="form-group mt-4 ms-5">
                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="periode">Periode</label></div>
                  <div class="col"> <input type="text" class="form-control" name="periode" id="periode" value="{{old('periode', $jadwal->periode)}}" readonly></div>
                </div>


                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="desc">Bulan Pelaksanaan</label></div>
                  <div class="col"> <input type="text" class="form-control" @error('bulan') is-invalid @enderror name="bulan" id="bulan" value="{{old('bulan', $jadwal->bulan)}}" placeholder="Masukan Bulan Pelaksanaan"></div>
                  @error('bulan')
                  <div class="invalid-feedback">
                    Bulan Pelaksanaan Harus Diisi
                  </div>
                  @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="link">Batas Pendaftaran</label></div>
                  <div class="col"> <input type="text" class="form-control" @error('batasdaftar') is-invalid @enderror name="batasdaftar" id="batasdaftar" value="{{old('batasdaftar', $jadwal->batasdaftar)}}" placeholder="Masukan Batas Pendaftaran"></div>
                  @error('batasdaftar')
                  <div class="invalid-feedback">
                    Batas Pendaftaran Harus Diisi
                  </div>
                  @enderror
                </div>


              </div>
              <div class='text-center'>
                <button class="btn btn-lg btn-primary mb-3" type="submit">Update Layanan</button>
                <a href="/admin/jadwalukom" class="btn btn-lg btn-primary ms-3  mb-3">Batal</a>
              </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
