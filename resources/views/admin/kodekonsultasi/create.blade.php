@extends('layout.main-admin')

@section('container')

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Buat Kode Konsultasi Baru</h1>

    <!-- Main Content -->
    <div class="card shadow">
        <div class="card-body">
            <div class="col-lg-6">
                <form action="/admin/kodekonsultasi/" method="POST" class="ms-5" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                      <label for="title" class="form-label">Jenis Konsultasi</label>
                      <input type="text" class="form-control @error('jenis') is-invalid @enderror" id="jenis" name="jenis" value="{{old('jenis')}}">
                        @error('jenis')
                            <div class="invalid-feedback">
                                {{ $message}}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Kode Konsultasi</label>
                        <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode" value="{{old('kode')}}">
                        @error('kode')
                        <div class="invalid-feedback">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                      <div class="col text-center">
                      <button type="submit" class="btn btn-primary">Buat Kode Konsultasi</button>
                      <a href="/admin/kodekonsultasi" class="btn btn-primary ms-3">Batal</a>
                      </div>
                  </form>
            </div>
        </div>
    </div>
</div>


<!-- End of Main Content -->


        <script>

            // const title = document.querySelector('#title');
            // const slug = document.querySelector('#slug');

            // title.addEventListener('change', function(){
            //     fetch('/admin/publikasi/cekSlug?title='+title.value)
            //     .then(response => response.json())
            //     .then(data => slug.value = data.slug)
            // });

        const title = document.querySelector('#title');
        const slug = document.querySelector('#slug');

        title.addEventListener('change', function(){
            fetch('/admin/publikasi/checkSlug?title=' + title.value)
            .then(response => response.json())
            .then(data => slug.value = data.slug)
        });


        // document.addEventListener('trix-files-accept',function(e){
        //     e.preventDefault();
        // })


        document.addEventListener('trix-files-accept',function(e){
    e.preventDefault();
})
        </script>


@endsection
