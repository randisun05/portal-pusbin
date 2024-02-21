@extends('layout.main-admin')

@section('container')


    <!-- Page Heading -->
<div class="container-fluid mt-5">
    <h1 class="text-center">Preview Layanan {{$layanan->nama}}</h1>
    <a href="/admin/layanan" class="btn btn-success"><box-icon name='arrow-back' size='xs'></box-icon>Kembali</a>
    <a href="/admin/layanan/{{$layanan->id}}/edit" class="btn btn-success"><box-icon type='solid' name='edit' size='xs'></box-icon>Edit</a>
    <form action="/admin/layanan/{{$layanan->id}}" method="POST" class="d-inline">
        @method('delete')
        @csrf
        <button class="btn btn-success" onclick="return confirm('Lanjutkan Hapus Layanan')"><box-icon name='trash' size='xs'></box-icon>Delete</button>
    </form>
</div>


    <!-- Main Content -->
<div class="container-fluid mt-5">
    <div class="row justify-content-center mt-5" style="min-height: 100vh;">
        <div class="col-4 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <div class="shadow bg-light rounded">
                <div class="wow fadeInUp" data-wow-delay="0.3s">
                    <a href="{{$layanan->link}}" target="_blank">
                    <div class="service-item d-flex flex-column text-center rounded">
                        <div class="service-icon flex-shrink-0">
                            <img src="{{asset('storage/' . $layanan->image)}}" width="150 px">
                        </div>
                        <h5 class="mb-3">{{$layanan->nama}}</h5>
                        <p class="m-0">{{$layanan->deskripsi}}</p>
                        <a class="btn btn-square" href="{{$layanan->link}}" target="_blank"><box-icon name='up-arrow-alt'></box-icon></a></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->
@endsection
