@extends('layout.main-admin')

@section('container')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Daftar Layanan</h1>
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a class="btn btn-primary" href="/admin/layanan/create"><i class="fas fa-plus me-2"></i>Buat Layanan</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Layanan</th>
                            <th class="text-center">Deskripsi</th>
                            <th class="text-center">Link Layanan</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    @foreach ($layanans as $layanan )
                    <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td>{{$layanan->nama}}</td>
                        <td>{{$layanan->deskripsi}}</td>
                        <td>{{$layanan->link}}</td>
                        <td class="text-center">
                            <a href="/admin/layanan/{{$layanan->id}}" class="badge bg-info"><i
                                    class="fas fa-eye"></i></a>
                            <a href="/admin/layanan/{{$layanan->id}}/edit" class="badge bg-warning"><i
                                    class="fas fa-edit"></i></a>
                            <form action="/admin/layanan/{{$layanan->id}}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="badge bg-danger border-0"
                                    onclick="return confirm('Lanjutkan Untuk Menghapus Data')"><i
                                        class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    <tfoot>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Layanan</th>
                            <th class="text-center">Deskripsi</th>
                            <th class="text-center">Link Layanan</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->


@endsection
