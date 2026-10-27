@extends('layout.main-admin')

@section('container')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Tambah Dokumen Repository</h1>
        @if (session()->has('success'))
            <div class="alert alert-success col-lg-8" role="alert">
            {{session('success')}}
            </div>
        @endif

    <!-- Main Content -->

    <div class="card shadow">
        <div class="card-body">
            <form class="jdihjfk" action="/admin/repository" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group mt-4 ms-5">
                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="title">Judul</label></div>
                    <div class="col"> <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
                    value="{{old('title')}}" placeholder="Masukan judul dokumen/peraturan"></div>
                    @error('title')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="deskripsi">Isi / Deskripsi</label></div>
                  <div class="col"> <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" rows="6"
                    placeholder="Tulis ringkasan, isi peraturan, atau pengetahuan yang relevan di sini">{{old('deskripsi')}}</textarea></div>
                    @error('deskripsi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="link">Link Dokumen (opsional)</label></div>
                  <div class="col"> <input type="text" class="form-control @error('link') is-invalid @enderror" name="link" id="link"
                    value="{{old('link')}}" placeholder="https://... (kosongkan jika tidak ada)"></div>
                    @error('link')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="image">Gambar Sampul (opsional)</label></div>
                  <div class="col"> <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image"></div>
                    @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                     @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="status">Status</label></div>
                  <div class="col">
                    <select class="form-select @error('status') is-invalid @enderror" name="status" id="status">
                        <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>Publikasikan (tampil di halaman Repository publik)</option>
                        <option value="internal" {{ old('status') === 'internal' ? 'selected' : '' }}>Internal saja (tidak tampil publik, hanya jadi pengetahuan chat)</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="col text-center m-3">
                <button class="btn btn-lg btn-primary mt-3" type="submit">Simpan</button>
                <a href="/admin/repository" class="btn btn-lg btn-primary ms-4 mt-3">Batal</a>
              </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->


@endsection
