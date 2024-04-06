@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.web.header-detail')
@include('layout.partial.notif')
<!-- Form Usulan Konsultasi -->
<div class="container-xxl py-4">
    <div class="row">
        <div class="col-md-6">
            <div class="tp-blog-main-img mt-15 p-relative">
                <img class="w-img" src="{{asset ('assets/img/konsul1.png') }} " style="width: 100%" alt="blog">
                <img class="w-img" src="{{asset ('assets/img/konsul1.png') }}" style="width: 100%" alt="blog">
            </div>
        </div>
        <div class="col-md-6 ">
            <form class="Konsultasi" id="form-konsultasi" action="/konsultasi/{{ $kegiatan->slug }}/store"
                method="POST">
                @csrf
                {{-- ID KEGIATAN --}}
                <input type="hidden" id="kegiatan_id" name="kegiatan_id" value="{{ $kegiatan->id }}">


                {{-- NIP --}}
                <div class="py-4">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip"
                        required maxlength="18" value="{{ old('nip') }}" maxlength="18"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Masukan NIP">

                    @error('nip')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>


                {{-- NAMA --}}
                <div class="mb-4">
                    <label for="nama" class="form-label">NAMA LENGKAP</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                        value="{{ old('nama') }}" placeholder="Masukan nama lengkap">

                    @error('nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div class="mb-4">
                    <label for="nama" class="form-label">EMAIL AKTIF</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email') }}" placeholder="Masukan email aktif">

                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- JABATAN --}}
                <div class="mb-4">
                    <label for="jabatan" class="form-label">JABATAN</label>
                    <select type="form-select" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan"
                         name="jabatan" value="{{ old('jabatan') }}">
                        <option value="" disabled selected>Pilih Jabatan</option>
                        <option value="Analis SDM Aparatur">Analis SDM Aparatur</option>
                        <option value="Asesor SDM Aparatur">Asesor SDM Aparatur</option>
                        <option value="Auditor Manajemen ASN">Auditor Manajemen ASN</option>
                        <option value="Pranata SDM Aparatur">Pranata SDM Aparatur</option>
                    </select>

                    @error('jabatan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- INSTANSI --}}
                <div class="mb-3">
                    <label for="instansi" class="form-label">INSTANSI</label>
                    <input type="text" class="form-control @error('instansi') is-invalid @enderror" id="instansi"
                        name="instansi" value="{{ old('instansi') }}" placeholder="Masukan Instansi">

                    @error('instansi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- Button --}}
                <div class="col text-center m-3">
                    <button type="button" class="btn btn-primary" id="btn-konfirmasi">DAFTAR</button>
                    <a href="/konsultasi" class="btn btn-danger" id="batal">BATAL</a>
                </div>
        </div>
        </form>
    </div>
</div>



@include('layout.web.footer')

<!-- Skrip SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('btn-konfirmasi').addEventListener('click', function() {
                // Menampilkan SweetAlert konfirmasi
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Pendaftaran akan dikirim.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Kirim!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    // Jika pengguna menekan tombol "Ya, Simpan!"
                    if (result.isConfirmed) {
                        // Submit form
                        document.getElementById('form-konsultasi').submit();
                        // Menampilkan SweetAlert sukses
                    }
                });
            });
        });
</script>
@endsection
