@extends('layout.main-admin')

@section('container')

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Mengubah Publikasi</h1>

    <!-- Main Content -->
    <div class="card shadow">
        <div class="card-body">
            <div class="col-lg-6 ms-5">
                <form class="post" action="/admin/publikasi/{{ $post->id }}" method="POST" class="mb-5 ms-5" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="mb-3">
                      <label for="title" class="form-label">Title</label>
                      <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{old('title', $post->title)}}">
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message}}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{old('slug', $post->slug)}}">
                        @error('slug')
                        <div class="invalid-feedback">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>
                      <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select @error('category') is-invalid @enderror" name="category_id">
                            @foreach ($categories as $category )
                                @if (old('category_id', $post->category_id) == $category->id)
                                    <option value="{{$category->id}}" selected>{{$category->name}}</option>
                                @else
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endif
                            @endforeach
                          </select>
                            @error('category')
                            <div class="invalid-feedback">
                                {{ $message}}
                            </div>
                            @enderror
                       </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Foto</label>
                            <input type="hidden" name="oldImage" value="{{ $post->image}}">
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                            @error('image')
                            <div class="invalid-feedback">
                                {{ $message}}
                            </div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="title" class="form-label">Nama Dokumen</label>
                            <input type="text" class="form-control @error('namadocument') is-invalid @enderror" id="namadocument" name="namadocument" value="{{old('namadocument')}}">
                              @error('namadocument')
                                  <div class="invalid-feedback">
                                      {{ $message}}
                                  </div>
                              @enderror
                          </div>

                          <div class="mb-3">
                            <label for="category" class="form-label">Dokumen</label>
                            <input type="hidden" name="oldImage" value="{{ $post->image}}">
                            <input type="file" name="document" class="form-control @error('document') is-invalid @enderror" id="document" name="document">
                            @error('document')
                                <div class="invalid-feedback">
                                    {{ $message}}
                                </div>
                            @enderror
                          </div>

                      <div class="mb-3">
                        <label for="category" class="form-label">Body</label>
                        <input id="body" type="hidden" name="body" class="@error('body') is-invalid @enderror" id="body" name="body" value="{{old('body', $post->body)}}">
                        <trix-editor input="body"></trix-editor>
                        @error('body')
                            <div class="invalid-feedback">
                                {{ $message}}
                            </div>
                        @enderror
                      </div>


                      <div class="col text-center m-3">
                        <button type="submit" class="btn btn-primary">Update Publikasi</button>
                        <a href="/admin/publikasi" class="btn btn-primary ms-3">Batal</a>
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
