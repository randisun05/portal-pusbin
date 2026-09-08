@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Edit Misi</h1>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
        {{session('success')}}
        </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow">

        <div class="card-body ">
            <form action="/admin/misi/{{$item->id}}" method="POST">
                @method('put')
                @csrf
              <div class="form-group mt-4 ms-5">
                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="isi">Isi Misi</label></div>
                  <div class="col"> <textarea class="form-control" @error('isi') is-invalid @enderror name="isi" id="isi" rows="2">{{old('isi', $item->isi)}}</textarea></div>
                  @error('isi')
                  <div class="invalid-feedback">
                      {{$message}}
                  </div>
                  @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                    <div class="col col-lg-2"><label for="urutan">Urutan Tampil</label></div>
                    <div class="col"> <input type="number" class="form-control" @error('urutan') is-invalid @enderror name="urutan" id="urutan" value="{{old('urutan', $item->urutan)}}"></div>
                    @error('urutan')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
              </div>
              <div class='text-center'>
                <button class="btn btn-lg btn-primary mb-3" type="submit">Update</button>
                <a href="/admin/misi" class="btn btn-lg btn-primary ms-3  mb-3">Batal</a>
              </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
