@extends('layout.main-admin')

@section('container')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Jawab Usulan Konsultasi Online</h1>
    <p class="text-center text-muted">Tiket: <strong>{{ $konsultasi->tiket }}</strong> &middot; Status: {{ $konsultasi->jawab ? 'Sudah Dijawab' : 'Belum Dijawab' }}</p>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
        {{session('success')}}
        </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow">
        <div class="card-body">
            <form class="Konsultasi" action="/admin/konsultasi/{{$konsultasi->id}}" method="POST">
                @method('put')
                @csrf
              <div class="form-group mt-4 ms-5">
                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="nama">NIP</label></div>
                  <div class="col"> <input type="text" class="form-control" @error('nip') is-invalid @enderror name="nip" id="nip" value="{{old('nip', $konsultasi->nip)}}" disabled></div>
                  @error('nip')
                  <div class="invalid-feedback">
                    NIP Konsultasi Harus Diisi
                  </div>
                  @enderror
          
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="nama">Nama</label></div>
                  <div class="col"> <input type="text" class="form-control" name="nama" id="nama" value="{{ $konsultasi->nama }}" disabled></div>
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="jenis">Jenis Konsultasi</label></div>
                  <div class="col"> <input type="text" class="form-control" name="jenis" id="jenis" value="{{ optional($konsultasi->kode_konsultasi)->jenis }}" disabled></div>
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="link">Jadwal</label></div>
                  <div class="col"> <input type="text" class="form-control" @error('jadwal') is-invalid @enderror name="jadwal" id="jadwal" value="{{old('jadwal', $konsultasi->jadwal)}}" disabled></div>
                  @error('jadwal')
                  <div class="invalid-feedback">
                    Jadwal Konsultasi Harus Diisi
                  </div>
                  @enderror
                </div>

                <div class="row row-cols-3 mb-4">
                  <div class="col col-lg-2"><label for="jadwalfix">Jadwal Fix</label></div>
                  <div class="col"> <input type="datetime-local" class="form-control" value="" @error('jadwalfix') is-invalid @enderror name="jadwalfix" id="jadwalfix" value="{{old('jadwalfix', $konsultasi->jadwalfix)}}" placeholder="Masukan Jadwalfix Kosultasi"></div>
                  @error('jadwalfix')
                  <div class="invalid-feedback">
                    Jadwal Fix Konsultasi Harus Diisi
                  </div>
                  @enderror
                </div>

               <div class="row row-cols-3 mb-4">
                <div class="col col-lg-2"><label for="jadwalfix">Link</label></div>
                <div class="col"> <input type="text" class="form-control" @error('link') is-invalid @enderror name="link" id="link" value="{{old('link', $konsultasi->link)}}" placeholder="Masukan link Kosultasi"></div>
                @error('link')
                <div class="invalid-feedback">
                  Link Konsultasi Harus Diisi
                </div>
                @enderror
               </div>

               <div class="row row-cols-3 mb-4">
                <div class="col col-lg-2"><label for="jadwalfix">PIC</label></div>
                <div class="col"> <input type="text" class="form-control" @error('pic') is-invalid @enderror name="pic" id="pic" value="{{old('pic', $konsultasi->pic)}}" placeholder="Masukan PIC Kosultasi"></div>
                @error('pic')
                <div class="invalid-feedback">
                  PIC Konsultasi Harus Diisi
                </div>
                @enderror
               </div>

                 <div class="row row-cols-3 mb-4">
                 <div class="col col-lg-2"><label for="nama">Keterangan</label></div>
                  <div class=""> <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" id="keterangan" rows="8">{{ old('keterangan', $konsultasi->keterangan) }}</textarea></div>
                  @error('keterangan')
                  <div class="invalid-feedback">
                    Keterangan Harus Diisi
                </div>
                @enderror
               </div>

              <div class='text-center'>
                <button class="btn btn-lg btn-primary mt-3" type="submit">Kirim Jawaban</button>
                <a href="/admin/konsultasi-tiket" class="btn btn-lg btn-primary mt-3  ms-3">Batal</a>
              </div>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->
@endsection
