@extends('layout.main-admin')

@section('container')
<div class="container-fluid">
    <h1 class="h3 mb-2 mt-5 text-center">Edit Halaman Layanan</h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="/admin/layanan-halaman/{{ $halaman->slug }}" method="POST">
                @method('put')
                @csrf
                <div class="mt-4 ms-lg-5 me-lg-5">
                    @include('admin.layanan-halaman._form')
                </div>
                <div class="text-center m-3">
                    <button class="btn btn-lg btn-primary" type="submit">Simpan</button>
                    <a href="/admin/layanan-halaman" class="btn btn-lg btn-outline-secondary ms-3">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
