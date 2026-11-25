@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Tambah Jadwal Ujikom</h1>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
        {{session('success')}}
        </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow">
        <div class="card-body">
            <form action="/admin/jadwalukom" method="POST">
                @csrf
                <div class="form-group mt-4 ms-5">
                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="periode">Periode</label></div>
                        <div class="col"> <input type="text" class="form-control @error('periode') is-invalid @enderror" name="periode" id="periode" value="{{old('periode')}}" placeholder="Contoh: I"></div>
                        @error('periode')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="bulan">Bulan</label></div>
                        <div class="col"> <input type="text" class="form-control @error('bulan') is-invalid @enderror" name="bulan" id="bulan" value="{{old('bulan')}}" placeholder="Contoh: Februari"></div>
                        @error('bulan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="batasdaftar">Batas Pendaftaran</label></div>
                        <div class="col"> <input type="text" class="form-control @error('batasdaftar') is-invalid @enderror" name="batasdaftar" id="batasdaftar" value="{{old('batasdaftar')}}" placeholder="Contoh: Akhir Desember Tahun Sebelumnya"></div>
                        @error('batasdaftar')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col text-center m-3">
                    <button class="btn btn-lg btn-primary mt-3" type="submit">Simpan</button>
                    <a href="/admin/jadwalukom" class="btn btn-lg btn-primary ms-4 mt-3">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
