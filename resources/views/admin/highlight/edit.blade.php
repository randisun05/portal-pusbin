@extends('layout.main-admin')

@section('container')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Edit Konten Beranda</h1>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
        {{session('success')}}
        </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow">

        <div class="card-body ">
            <form class="Highlight" action="/admin/highlight/{{$highlight->id}}" method="POST" enctype="multipart/form-data">
                @method('put')
                @csrf
              <div class="form-group mt-4 ms-5">

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="group">Bagian Beranda</label></div>
                  <div class="col">
                      <select class="form-select @error('group') is-invalid @enderror" name="group" id="group">
                          @foreach ($groups as $slug => $label)
                              <option value="{{ $slug }}" {{ old('group', $highlight->group) == $slug ? 'selected' : '' }}>{{ $label }}</option>
                          @endforeach
                      </select>
                  </div>
                  @error('group')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="name">Judul</label></div>
                  <div class="col"> <input type="text" class="form-control" @error('name') is-invalid @enderror name="name" id="name" value="{{old('name', $highlight->name)}}" placeholder="Masukan Judul"></div>
                  @error('name')
                  <div class="invalid-feedback">
                      Judul Harus Diisi
                  </div>
                  @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="desc">Deskripsi</label></div>
                  <div class="col"> <input type="text" class="form-control" @error('desc') is-invalid @enderror name="desc" id="desc" value="{{old('desc', $highlight->desc)}}" placeholder="Masukan Deskripsi"></div>
                  @error('desc')
                  <div class="invalid-feedback">
                    Deskripsi Harus Diisi
                  </div>
                  @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                    <div class="col col-lg-2"><label for="icon">Icon (opsional)</label></div>
                    <div class="col">
                        <input type="text" class="form-control @error('icon') is-invalid @enderror" name="icon" id="icon" value="{{old('icon', $highlight->icon)}}" placeholder="mis. bi-headset">
                        <div class="form-text">Nama class ikon dari <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a>, tanpa awalan "bi", contoh: <code>bi-headset</code>.</div>
                    </div>
                    @error('icon')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                    <div class="col col-lg-2"><label for="link">Link (opsional)</label></div>
                    <div class="col"> <input type="text" class="form-control @error('link') is-invalid @enderror" name="link" id="link" value="{{old('link', $highlight->link)}}" placeholder="mis. /survei"></div>
                    @error('link')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                    <div class="col col-lg-2"><label for="logo">Gambar (opsional)</label></div>
                    <div class="col">
                        @if($highlight->image)
                            <img src="{{ asset('storage/' . $highlight->image) }}" style="height:80px" class="mb-2 d-block">
                        @endif
                        <input type="file" class="form-control" @error('image') is-invalid @enderror name="image" id="image" placeholder="Masukan Gambar" accept=".jpg, .jpeg, .png">
                    </div>
                      @error('image')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                       @enderror
                      </div>
              </div>
              <div class='text-center'>
                <button class="btn btn-lg btn-primary mb-3" type="submit">Update Konten</button>
                <a href="/admin/highlight?group={{ $highlight->group }}" class="btn btn-lg btn-primary ms-3 mb-3">Batal</a>
              </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
