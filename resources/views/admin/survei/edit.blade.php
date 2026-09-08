@extends('layout.main-admin')

@section('container')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Edit Survei</h1>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
        {{session('success')}}
        </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow">

        <div class="card-body ">
            <form class="Layanan" action="/admin/survei/{{$data->id}}" method="POST" enctype="multipart/form-data">
                @method('put')
                @csrf
              <div class="form-group mt-4 ms-5">
                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="nama">Nama Survei</label></div>
                  <div class="col"> <input type="text" class="form-control" @error('title') is-invalid @enderror name="title" id="title" value="{{old('title', $data->title)}}" placeholder="Masukan Nama Peraturan"></div>
                  @error('title')
                  <div class="invalid-feedback">
                      Nama Survei Harus Diisi
                  </div>
                  @enderror
                </div>
                <div class="row row-cols-3 mb-4">
                    <div class="col col-lg-2"><label for="type">Skala Penilaian</label></div>
                    <div class="col">
                        <select class="form-select @error('type') is-invalid @enderror" name="type" id="type">
                            <option value="" disabled>Pilih Skala Penilaian</option>
                            @foreach (['1' => 'Teks', '2' => 'Ya/Tidak', '3' => 'Skala Penilaian 3', '4' => 'Skala Penilaian 4'] as $value => $label)
                                <option value="{{ $value }}" {{ (string) old('type', $data->type) === (string) $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('type')
                        <div class="invalid-feedback">
                            Masukan Skala Penilaian
                        </div>
                        @enderror
                    </div>
                </div>

              <div class='text-center'>
                <button class="btn btn-lg btn-primary mb-3" type="submit">Update Survei</button>
                <a href="/admin/survei" class="btn btn-lg btn-primary ms-3  mb-3">Batal</a>
              </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
