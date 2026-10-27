@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Pengaturan Nomor Sertifikat</h1>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
        {{session('success')}}
        </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow">
        <div class="card-body">
            <form action="/admin/pengaturan-sertifikat" method="POST">
                @method('put')
                @csrf
                <div class="form-group mt-4 ms-5 me-5">

                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-3"><label for="prefix">Prefix Nomor</label></div>
                        <div class="col">
                            <input type="text" class="form-control @error('prefix') is-invalid @enderror" name="prefix" id="prefix" value="{{ old('prefix', $pengaturan->prefix) }}">
                            @error('prefix')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-3"><label for="digit_urut">Jumlah Digit Urut</label></div>
                        <div class="col">
                            <input type="number" min="1" max="10" class="form-control @error('digit_urut') is-invalid @enderror" name="digit_urut" id="digit_urut" value="{{ old('digit_urut', $pengaturan->digit_urut) }}">
                            @error('digit_urut')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-3"><label for="reset_tahunan">Reset Urutan Tiap Tahun</label></div>
                        <div class="col">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="reset_tahunan" id="reset_tahunan" value="1" {{ old('reset_tahunan', $pengaturan->reset_tahunan) ? 'checked' : '' }}>
                                <label class="form-check-label" for="reset_tahunan">Nomor urut dimulai dari 1 lagi setiap pergantian tahun</label>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        Contoh format nomor: <strong>{{ old('prefix', $pengaturan->prefix) }}/{{ date('Y') }}/{{ str_pad('1', old('digit_urut', $pengaturan->digit_urut), '0', STR_PAD_LEFT) }}</strong>
                    </div>

                    <div class="col text-center m-3">
                        <button class="btn btn-lg btn-primary mt-3" type="submit">Simpan</button>
                        <a href="/admin/sertifikat-template" class="btn btn-lg btn-secondary ms-4 mt-3">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
