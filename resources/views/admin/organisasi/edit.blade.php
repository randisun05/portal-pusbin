@extends('layout.main-admin')

@section('container')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Edit Anggota Struktur Organisasi</h1>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
        {{session('success')}}
        </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow">

        <div class="card-body ">
            <form class="Organisasi" action="/admin/organisasi/{{$unit->id}}" method="POST" enctype="multipart/form-data">
                @method('put')
                @csrf
              <div class="form-group mt-4 ms-5">
                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="nama">Nama</label></div>
                  <div class="col"> <input type="text" class="form-control" @error('nama') is-invalid @enderror name="nama" id="nama" value="{{old('nama', $unit->nama)}}" placeholder="Masukan Nama Lengkap &amp; Gelar"></div>
                  @error('nama')
                  <div class="invalid-feedback">
                      {{$message}}
                  </div>
                  @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="jabatan">Jabatan</label></div>
                  <div class="col"> <input type="text" class="form-control" @error('jabatan') is-invalid @enderror name="jabatan" id="jabatan" value="{{old('jabatan', $unit->jabatan)}}" placeholder="Masukan Jabatan"></div>
                  @error('jabatan')
                  <div class="invalid-feedback">
                    {{$message}}
                  </div>
                  @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                    <div class="col col-lg-2"><label for="unit">Unit / Pokja</label></div>
                    <div class="col"> <input type="text" class="form-control" @error('unit') is-invalid @enderror name="unit" id="unit" value="{{old('unit', $unit->unit)}}" placeholder="Contoh: Pokja 1, Sekretariat, dll (opsional)"></div>
                    @error('unit')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                    <div class="col col-lg-2"><label for="parent_id">Atasan Langsung</label></div>
                    <div class="col">
                        <select class="form-control" @error('parent_id') is-invalid @enderror name="parent_id" id="parent_id">
                            <option value="">-- Tanpa Atasan (Puncak Struktur) --</option>
                            @foreach ($parents as $parent)
                                <option value="{{$parent->id}}" {{ old('parent_id', $unit->parent_id) == $parent->id ? 'selected' : '' }}>{{$parent->nama}} ({{$parent->jabatan}})</option>
                            @endforeach
                        </select>
                    </div>
                    @error('parent_id')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                    <div class="col col-lg-2"><label for="urutan">Urutan Tampil</label></div>
                    <div class="col"> <input type="number" class="form-control" @error('urutan') is-invalid @enderror name="urutan" id="urutan" value="{{old('urutan', $unit->urutan)}}" placeholder="0"></div>
                    @error('urutan')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                    <div class="col col-lg-2"><label for="deskripsi">Deskripsi Singkat</label></div>
                    <div class="col"> <textarea class="form-control" @error('deskripsi') is-invalid @enderror name="deskripsi" id="deskripsi" rows="3" placeholder="Opsional">{{old('deskripsi', $unit->deskripsi)}}</textarea></div>
                    @error('deskripsi')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                    <div class="col col-lg-2"><label for="foto">Foto</label></div>
                    <input type="hidden" name="oldFoto" value="{{$unit->foto}}">
                    @if($unit->foto)
                        <div class="col-lg-2">
                            <img src="{{asset('storage/' . $unit->foto)}}" style="height:80px" class="mb-2">
                        </div>
                    @endif
                    <div class="col"> <input type="file" class="form-control" @error('foto') is-invalid @enderror name="foto" id="foto" placeholder="Masukan Foto" accept=".jpg, .jpeg, .png"></div>
                      @error('foto')
                      <div class="invalid-feedback">
                        {{$message}}
                      </div>
                       @enderror
                      </div>
              </div>
              <div class='text-center'>
                <button class="btn btn-lg btn-primary mb-3" type="submit">Update</button>
                <a href="/admin/organisasi" class="btn btn-lg btn-primary ms-3  mb-3">Batal</a>
              </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
