@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.web.header-detail')
@include('layout.partial.notif')

<main>
<!-- Form Pengajuan Konsultasi (tiket) -->
<section class="section">
<div class="container">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <p class="text-muted text-center">Isi formulir berikut untuk mengajukan konsultasi. Anda akan menerima nomor tiket untuk memantau jawaban di halaman <a href="/konsultasi/cari">Cari Tiket</a>.</p>
            <form class="Konsultasi" id="form-usul" action="/konsultasi/usul" method="POST">
                @csrf
                @include('layout.partial.honeypot')
                @include('layout.partial.recaptcha')

                <div class="mb-3">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" required maxlength="18" inputmode="numeric" value="{{ old('nip') }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="18 digit NIP">
                    @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">NAMA LENGKAP</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" required maxlength="255" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap">
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">EMAIL AKTIF</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required maxlength="255" value="{{ old('email') }}" placeholder="Masukkan email aktif">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="instansi" class="form-label">INSTANSI</label>
                    <input type="text" class="form-control @error('instansi') is-invalid @enderror" id="instansi" name="instansi" required maxlength="255" value="{{ old('instansi') }}" placeholder="Masukkan instansi">
                    @error('instansi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="kode_id" class="form-label">PERIHAL KONSULTASI</label>
                    <select class="form-select @error('kode_id') is-invalid @enderror" name="kode_id" id="kode_id" required>
                        <option value="" disabled {{ old('kode_id') ? '' : 'selected' }}>Pilih perihal</option>
                        @foreach ($kode as $k)
                            <option value="{{ $k->id }}" {{ (string) old('kode_id') === (string) $k->id ? 'selected' : '' }}>{{ $k->jenis }}</option>
                        @endforeach
                    </select>
                    @error('kode_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">DESKRIPSI PERMASALAHAN</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" required maxlength="2000" rows="5" placeholder="Jelaskan hal yang ingin dikonsultasikan">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="jadwal" class="form-label">USULAN TANGGAL KONSULTASI</label>
                    <input type="date" class="form-control @error('jadwal') is-invalid @enderror" id="jadwal" name="jadwal" required min="{{ now()->toDateString() }}" value="{{ old('jadwal') }}">
                    @error('jadwal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="text-center m-3">
                    <button type="submit" class="btn btn-primary" id="kirim">KIRIM USULAN</button>
                    <a href="/konsultasi" class="btn btn-danger">BATAL</a>
                </div>
            </form>
            <div class="text-center">
                <a href="/konsultasi/cari"><u>Sudah punya nomor tiket? Cari di sini</u></a>
            </div>
        </div>
    </div>
</div>
</section>
</main>

@include('layout.web.footer')
@endsection
