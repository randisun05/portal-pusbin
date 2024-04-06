@extends('layout.main-admin')

@section('container')

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Mengubah Publikasi</h1>

    <!-- Main Content -->
    <div class="card shadow">
        <div class="card-body">
            <div class="col-lg-6">
                <form action="/admin/kegiatan/{{ $kegiatan->id }}" method="POST" class="ms-5" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="mb-3">
                      <label for="title" class="form-label">Nama Kegiatan</label>
                      <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{old('nama', $kegiatan->nama)}}">
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message}}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Waktu Pelaksanaan</label>
                        <input type="datetime-local" class="form-control @error('waktu') is-invalid @enderror" id="waktu" name="waktu" value="{{old('waktu', $kegiatan->waktu)}}">
                        @error('waktu')
                        <div class="invalid-feedback">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Link Kegiatan</label>
                            <input type="text" class="form-control @error('link') is-invalid @enderror" id="link" name="link" value="{{old('link', $kegiatan->link)}}">
                              @error('link')
                                  <div class="invalid-feedback">
                                      {{ $message}}
                                  </div>
                              @enderror
                          </div>

                          <div class="mb-3">
                            <label for="title" class="form-label">Jenis Kegiatan</label>
                            <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis">
                                <option value="Konsultasi" {{ old('jenis', $kegiatan->jenis) == 'Konsultasi' ? 'selected' : '' }}>Konsultasi</option>
                                <option value="Uji Kompetensi" {{ old('jenis', $kegiatan->jenis) == 'Uji Kompetensi' ? 'selected' : '' }}>Uji Kompetensi</option>
                                <option value="Sosialisasi" {{ old('jenis', $kegiatan->jenis) == 'Sosialisasi' ? 'selected' : '' }}>Sosialisasi</option>
                                <option value="Lainnya" {{ old('jenis', $kegiatan->jenis) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('jenis')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                          <div class="mb-3">
                            <label for="title" class="form-label">Status Kegiatan</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="1" {{ old('jenis', $kegiatan->status) == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('jenis', $kegiatan->status) == '0' ? 'selected' : '' }}>Non Aktif</option>
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

                      <div class="col text-center mt-3">
                        <button type="submit" class="btn btn-primary">Update Kegiatan</button>
                        <a href="/admin/kegiatan" class="btn btn-primary ms-3">Batal</a>
                      </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
