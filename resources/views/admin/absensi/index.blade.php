@extends('layout.main-admin')
@section('container')

 <!-- Begin Page Content -->
 <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Daftar Absensi Kegiatan</h1>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
             {{ session('success') }}
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

    <!-- Main Content -->
    <div class="card shadow">
        <div class="card-header py-3 mt-2">
            <form class="row g-3" class="Absensi" action="/admin/absensi">
                @csrf
                <label for="category" class="form-label mb-0">Nama Kegiatan</label>
                <div class="col-md-6">
                    <select class="form-select col-md-4 @error('kegiatan') is-invalid @enderror" name="search">
                        <option value="">Semua</option>
                        @foreach ($kegiatans as $kegiatan )
                            @if ($kegiatan->jenis != "survei")
                            @if (old('kegiatan_id') == $kegiatan->id)
                            <option value="{{$kegiatan->id}}" selected>{{$kegiatan->nama}}</option>
                            @else
                            <option value="{{$kegiatan->id}}">{{$kegiatan->nama}}</option>
                            @endif
                            @endif
                            @endforeach
                            @error('kegiatan')
                            <div class="invalid-feedback">
                            {{ $message}}
                            </div>
                            @enderror
                    </select>
                </div>
                <div class="col-auto">
                  <button type="submit" class="btn btn-primary">Cari</button>
                </div>
                <div class="col-auto ms-auto">
                  <a href="/admin/absensi/export{{ request('search') ? '?search='.request('search') : '' }}" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Export Excel
                  </a>
                  <a href="/admin/absensi/daftar-hadir{{ request('search') ? '?search='.request('search') : '' }}" class="btn btn-outline-secondary">
                    <i class="fas fa-print"></i> Cetak Daftar Hadir
                  </a>
                </div>
            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">NIP</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Jabatan</th>
                            <th class="text-center">Instansi</th>
                            <th class="text-center">Nama Kegiatan</th>
                        </tr>
                    </thead>
                    @foreach ($absensis as $absensi )
                    <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td>{{$absensi->nip}}</td>
                        <td>{{$absensi->nama}}</td>
                        <td>{{$absensi->jabatan}}</td>
                        <td>{{$absensi->instansi}}</td>
                        <td>{{$absensi->kegiatan->nama}}</td>
                    </tr>
                    @endforeach

                    <tfoot>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">NIP</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Jabatan</th>
                            <th class="text-center">Instansi</th>
                            <th class="text-center">Nama Kegiatan</th>
                        </tr>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            {{$absensis->links()}}
        </div>
    </div>
</div>


<!-- End of Main Content -->


@endsection
