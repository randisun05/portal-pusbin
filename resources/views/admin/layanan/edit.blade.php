@extends('layout.main-admin')

@section('container')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Edit Layanan</h1>
    @if (session()->has('success'))
    <div class="alert alert-success col-lg-8" role="alert">
        {{session('success')}}
    </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow">

        <div class="card-body ">
            <form class="Layanan" action="/admin/layanan/{{$layanan->id}}" method="POST" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="form-group mt-4 ms-5">
                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="nama">Nama Layanan</label></div>
                        <div class="col"> <input type="text" class="form-control" @error('nama') is-invalid @enderror
                                name="nama" id="nama" value="{{old('nama', $layanan->nama)}}"
                                placeholder="Masukan Nama Layanan"></div>
                        @error('nama')
                        <div class="invalid-feedback">
                            Nama Layanan Harus Diisi
                        </div>
                        @enderror
                    </div>

                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="desc">Descripsi Layanan</label></div>
                        <div class="col"> <input type="text" class="form-control" @error('deskripsi') is-invalid
                                @enderror name="deskripsi" id="deskripsi"
                                value="{{old('deskripsi', $layanan->deskripsi)}}"
                                placeholder="Masukan Deskripsi Layanan"></div>
                        @error('deskripsi')
                        <div class="invalid-feedback">
                            Deskripsi Layanan Harus Diisi
                        </div>
                        @enderror
                    </div>

                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="link">Link Layanan</label></div>
                        <div class="col"> <input type="text" class="form-control" @error('link') is-invalid @enderror
                                name="link" id="link" value="{{old('link', $layanan->link)}}"
                                placeholder="Masukan Link Layanan"></div>
                        @error('link')
                        <div class="invalid-feedback">
                            Link Layanan Harus Diisi
                        </div>
                        @enderror
                    </div>

                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="logo">Image</label></div>
                        <input type="hidden" name="oldImage" value="{{ $layanan->image}}">
                        <div class="col"> <input type="file" class="form-control" @error('image') is-invalid @enderror
                                name="image" id="image" placeholder="Masukan Image Layanan" accept=".jpg, .png, .jpeg">
                        </div>
                        @error('image')
                        <div class="invalid-feedback">
                            Please input Image layanan.
                        </div>
                        @enderror
                    </div>

                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="link">Status</label></div>
                        <div class="col">
                            <select class="form-select @error('perihal') is-invalid @enderror" id="status"
                                name="status">
                                <option value="1" {{$layanan->status == 1 ? 'selected' : ''}}>Aktif</option>
                                <option value="0" {{$layanan->status == 0 ? 'selected' : ''}}>Non-Aktif</option>
                            </select>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">
                                Status Layanan Harus Diisi
                            </div>
                            @enderror
                        </div>


                    </div>
                    <div class='text-center'>
                        <button class="btn btn-lg btn-primary mb-3" type="submit">Update Layanan</button>
                        <a href="/admin/layanan" class="btn btn-lg btn-primary ms-3  mb-3">Batal</a>
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
