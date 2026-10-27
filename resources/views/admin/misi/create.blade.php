@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Tambah Misi Baru</h1>
    @if (session()->has('success'))
    <div class="alert alert-success col-lg-8" role="alert">
        {{session('success')}}
    </div>
    @endif

    <!-- Main Content -->

    <div class="card shadow">
        <div class="card-body">
            <form action="/admin/misi" method="POST">
                @csrf
                <div class="form-group mt-4 ms-5">
                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="isi">Isi Misi</label></div>
                        <div class="col"> <textarea class="form-control" @error('isi') is-invalid @enderror
                                name="isi" id="isi" rows="2" placeholder="Masukan Isi Misi">{{old('isi')}}</textarea>
                        </div>
                        @error('isi')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="urutan">Urutan Tampil</label></div>
                        <div class="col"> <input type="number" class="form-control" @error('urutan') is-invalid @enderror
                                name="urutan" id="urutan" value="{{old('urutan', 0)}}">
                        </div>
                        @error('urutan')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col text-center m-3">
                        <button class="btn btn-lg btn-primary mt-3" type="submit">Simpan</button>
                        <a href="/admin/misi" class="btn btn-lg btn-primary ms-4 mt-3">Batal</a>
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->


@endsection
