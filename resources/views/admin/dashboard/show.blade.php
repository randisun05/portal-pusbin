@extends('layout.main-admin')

@section('container')


    <!-- Page Heading -->
<div class="container-fluid mt-5">
    <h1 class="text-center">Preview Dashboard {{$dashboard->nama}}</h1>
    <a href="/admin/dashboard" class="btn btn-success"><box-icon name='arrow-back' size='xs'></box-icon>Kembali</a>
    <a href="/admin/dashboard/{{$dashboard->id}}/edit" class="btn btn-success"><box-icon type='solid' name='edit' size='xs'></box-icon>Edit</a>
    <form action="/admin/dashboard/{{$dashboard->id}}" method="POST" class="d-inline">
        @method('delete')
        @csrf
        <button class="btn btn-success" onclick="return confirm('Lanjutkan Hapus Dashboard')"><box-icon name='trash' size='xs'></box-icon>Delete</button>
    </form>
</div>


    <!-- Main Content -->
<div class="container-xxl py-5">
    <div class="container py-5 px-lg-5 col-4 col-sm-8 col-md-6 col-lg-5 col-xl-4">
        <div class="row g-4">
            <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                <a href="{{$dashboard->link}}" target="_blank">
                <div class="feature-item bg-light rounded text-center p-4">
                    <img src="{{asset('storage/' . $dashboard->image)}}" alt="" width="350px">
                    <h5 class="mb-3">{{$dashboard->nama}}</h5>
                    <p class="m-0">{{$dashboard->deskripsi}}</p>
                </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
