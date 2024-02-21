@extends('layout.main-admin')

@section('container')

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Mengubah Kode Konsultasi</h1>

    <!-- Main Content -->
    <div class="card shadow">
        <div class="card-body">
            <div class="col-lg-6">
                <form class="post" action="/admin/kodekonsultasi/{{ $kode->id }}" method="POST" class="ms-5" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="mb-3">
                      <label for="title" class="form-label">Nama Konsultasi</label>
                      <input type="text" class="form-control @error('jenis') is-invalid @enderror" id="jenis" name="jenis" value="{{old('jenis', $kode->jenis)}}">
                        @error('jenis')
                            <div class="invalid-feedback">
                                {{ $message}}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Kode Konsultasi</label>
                        <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode" value="{{old('kode', $kode->kode)}}">
                        @error('kode')
                        <div class="invalid-feedback">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>


                      <div class="col text-center mt-3">
                        <button type="submit" class="btn btn-primary">Update Kode</button>
                        <a href="/admin/kodekonsultasi" class="btn btn-primary ms-3">Batal</a>
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
