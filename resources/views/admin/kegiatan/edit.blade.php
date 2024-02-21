@extends('layout.main-admin')

@section('container')

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Mengubah Publikasi</h1>

    <!-- Main Content -->
    <div class="card shadow">
        <div class="card-body">
            <div class="col-lg-6">
                <form class="post" action="/admin/kegiatan/{{ $kegiatan->id }}" method="POST" class="ms-5" enctype="multipart/form-data">
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
                        <input type="text" class="form-control @error('waktu') is-invalid @enderror" id="waktu" name="waktu" value="{{old('waktu', $kegiatan->waktu)}}">
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
                                @if (old('jenis',$kegiatan->jenis) == $kegiatan->jenis)
                                <option value="{{$kegiatan->jenis}}">{{$kegiatan->jenis}}</option>
                                @else
                                <option value="survei">Survei</option>
                                <option value="ujikom">Ujikom</option>
                                <option value="pemaparan">Pemaparan</option>
                                @endif
                            </select>
                              @error('jenis')
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

        <script>

            const title = document.querySelector('#title');
            const title = document.querySelector('#slug');

            title.addEventListner('change', function(){
                fetch('/admin/publikasi/cekSlug?title=' + title.value)
                .then(response => response.json())
                .then(data => slug.value = data.slug)
            });

        // const title = document.querySelector('#title');
        // const slug = document.querySelector('#slug');

        // title.addEventListener('change', function(){
        //     fetch('/admin/publikasi/checkSlug?title=' + title.value)
        //     .then(response => response.json())
        //     .then(data => slug.value = data.slug)
        // });
        // document.addEventListener('trix-files-accept',function(e){
        //     e.preventDefault();
        // })
        document.addEventListener('trix-files-accept',function(e){
    e.preventDefault();
})
        </script>


@endsection
