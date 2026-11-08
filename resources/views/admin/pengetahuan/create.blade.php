@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Tambah Materi Pengetahuan</h1>
    @if (session()->has('success'))
    <div class="alert alert-success col-lg-8" role="alert">
        {{session('success')}}
    </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow">
        <div class="card-body">
            <form action="/admin/pengetahuan" method="POST">
                @csrf
                <div class="form-group mt-4 ms-5">
                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="judul">Judul</label></div>
                        <div class="col"> <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                name="judul" id="judul" value="{{old('judul')}}" placeholder="mis. Syarat Pendaftaran Uji Kompetensi">
                        </div>
                        @error('judul')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="isi">Isi / Jawaban</label></div>
                        <div class="col">
                            <textarea class="form-control @error('isi') is-invalid @enderror"
                                name="isi" id="isi" rows="6" placeholder="Tuliskan penjelasan lengkap. Semakin detail, semakin baik chat AI menjawab.">{{old('isi')}}</textarea>
                        </div>
                        @error('isi')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="kategori">Kategori (opsional)</label></div>
                        <div class="col"> <input type="text" class="form-control @error('kategori') is-invalid @enderror"
                                name="kategori" id="kategori" value="{{old('kategori')}}" placeholder="mis. Uji Kompetensi, Konsultasi, Sertifikat">
                        </div>
                        @error('kategori')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="kata_kunci">Kata Kunci (opsional)</label></div>
                        <div class="col">
                            <input type="text" class="form-control @error('kata_kunci') is-invalid @enderror"
                                name="kata_kunci" id="kata_kunci" value="{{old('kata_kunci')}}" placeholder="pisahkan dengan koma, mis: ukom, jadwal, biaya">
                            <div class="form-text">Membantu chat menemukan materi ini walau pertanyaan pengunjung memakai istilah berbeda.</div>
                        </div>
                        @error('kata_kunci')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="urutan">Urutan Tampil</label></div>
                        <div class="col"> <input type="number" class="form-control @error('urutan') is-invalid @enderror"
                                name="urutan" id="urutan" value="{{old('urutan', 0)}}">
                        </div>
                        @error('urutan')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="aktif">Status</label></div>
                        <div class="col">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" name="aktif" id="aktif" value="1" {{ old('aktif', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="aktif">Aktif (dipakai chat AI)</label>
                            </div>
                        </div>
                    </div>

                    <div class="col text-center m-3">
                        <button class="btn btn-lg btn-primary mt-3" type="submit">Simpan</button>
                        <a href="/admin/pengetahuan" class="btn btn-lg btn-primary ms-4 mt-3">Batal</a>
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
