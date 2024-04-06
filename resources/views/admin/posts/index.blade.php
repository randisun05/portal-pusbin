@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Daftar Publikasi</h1>
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow">
        <div class="card-header py-3 mt-2">
            <a class="btn btn-primary" href="/admin/publikasi/create"><i class="fas fa-plus me-2"></i>Buat Publikasi</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Judul Publikasi</th>
                            <th class="text-center">Kategori Publikasi</th>
                            <th class="text-center">Tanggal Dibuat</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    @foreach ($posts as $post )
                    <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td>{{$post->title}}</td>
                        <td>{{$post->category->name}}</td>
                        <td>{{$post->created_at}}</td>
                        <td class="text-center"><a href="/admin/publikasi/{{$post->id}}" class="badge bg-info"><i
                                    class="fas fa-eye"></i></a>
                            <a href="/admin/publikasi/{{$post->id}}/edit" class="badge bg-warning"><i
                                    class="fas fa-edit"></i></a>
                            <form action="/admin/publikasi/{{$post->id}}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="badge bg-danger border-0"
                                    onclick="return confirm('Lanjutkan Hapus Publkasi')"><i
                                        class="fas fa-trash"></i></button>
                            </form>
                    </tr>
                    @endforeach
                    <tfoot>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Judul Publikasi</th>
                            <th class="text-center">Kategori Publikasi</th>
                            <th class="text-center">Tanggal Dibuat</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{$posts->links()}}
</div>



<!-- End of Main Content -->

@endsection
