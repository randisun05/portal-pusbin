@extends('layout.main-admin')

@section('container')

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Buat Kegiatan Baru</h1>

    <!-- Main Content -->
    <div class="card shadow">
        <div class="card-body">
            <div class="col-lg-6">
                <form action="/admin/kegiatan/" method="POST" class="ms-5" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                      <label for="title" class="form-label">Nama Kegiatan</label>
                      <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{old('nama')}}">
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message}}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Waktu Pelaksanaan</label>
                        <input type="datetime-local" class="form-control @error('waktu') is-invalid @enderror" id="waktu" name="waktu" value="{{old('waktu')}}">
                        @error('waktu')
                        <div class="invalid-feedback">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                      <div class="mb-3">
                        <label for="title" class="form-label">Link Kegiatan</label>
                        <input type="text" class="form-control @error('link') is-invalid @enderror" id="link" name="link" value="{{old('link')}}">
                          @error('link')
                              <div class="invalid-feedback">
                                  {{ $message}}
                              </div>
                          @enderror
                      </div>

                      <div class="mb-3">
                        <label for="title" class="form-label">Jenis Kegiatan</label>
                        <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis">
                        <option value="Konsultasi">Konsultasi</option>
                        <option value="Sosialisasi">Uji Kompetensi</option>
                        <option value="Sosialisasi">Sosialisasi</option>
                        <option value="Lainnya">Lainnya</option>
                        </select>
                        @error('jenis')
                              <div class="invalid-feedback">
                                  {{ $message}}
                              </div>
                          @enderror
                      </div>


                      <div class="mb-3">
                        <label for="title" class="form-label">Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept=".png, .jpg, .JPG, .JPEG, .jpeg"">
                          @error('image')
                              <div class="invalid-feedback">
                                  {{ $message}}
                              </div>
                          @enderror
                      </div>

                      <div class="col text-center">
                      <button type="submit" class="btn btn-primary">Buat Kegiatan</button>
                      <a href="/admin/kegiatan" class="btn btn-primary ms-3">Batal</a>
                      </div>
                  </form>
            </div>
        </div>
    </div>
</div>


<!-- End of Main Content -->


@endsection
