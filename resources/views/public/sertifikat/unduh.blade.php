@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.partial.notif')

<main>
@include('layout.web.header-detail')

<div class="container-fluid">
    <div class="row py-5">
        <div class="col-md-6 offset-md-3 py-4">
            <h4 class="mb-3 text-center">Unduh Sertifikat</h4>
            <p class="text-center text-muted mb-4">Masukkan NIP dan pilih kegiatan yang Anda ikuti untuk langsung mengunduh sertifikat Anda, apabila sudah diterbitkan oleh panitia.</p>

            @if (session()->has('error'))
                <div class="alert alert-danger text-center">{{ session('error') }}</div>
            @endif

            <form action="/sertifikat/unduh" method="POST">
                @csrf
                @include('layout.partial.honeypot')
                @include('layout.partial.recaptcha')

                <div class="mb-3">
                    <label for="kegiatan_id" class="form-label">Kegiatan</label>
                    <select class="form-select @error('kegiatan_id') is-invalid @enderror" name="kegiatan_id" id="kegiatan_id" required>
                        <option value="">-- Pilih Kegiatan --</option>
                        @foreach ($kegiatans as $kegiatan)
                            <option value="{{ $kegiatan->id }}" {{ old('kegiatan_id') == $kegiatan->id ? 'selected' : '' }}>{{ $kegiatan->nama }}</option>
                        @endforeach
                    </select>
                    @error('kegiatan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" id="nip" value="{{ old('nip') }}" required>
                    @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col text-center m-3">
                    <button type="submit" class="btn btn-primary mb-3" id="kirim">UNDUH SERTIFIKAT</button>
                </div>
            </form>
        </div>
    </div>
</div>
</main>

@include('layout.web.footer')
@endsection
