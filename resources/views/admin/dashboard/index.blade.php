@extends('layout.main-admin')

@section('container')


 <!-- Begin Page Content -->
 <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Daftar Dashboard</h1>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
             {{ session('success') }}
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


    <!-- Main Content -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <a  class="btn btn-primary" href="/admin/dashboard/create">Buat Dashboard</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Dashboard</th>
                            <th class="text-center">Deskripsi</th>
                            <th class="text-center">Link Dashboard</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    @foreach ($dashboards as $dashboard)
                    <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td>{{$dashboard->nama}}</td>
                        <td>{{$dashboard->deskripsi}}</td>
                        <td>{{$dashboard->link}}</td>
                        <td class="text-center">
                            <a href="/admin/dashboard/{{$dashboard->id}}" class="badge bg-info"><box-icon name='show' size='xs'></box-icon> </a>
                            <a href="/admin/dashboard/{{$dashboard->id}}/edit" class="badge bg-warning"><box-icon type='solid' name='edit' size='xs'></box-icon></a>
                            <form action="/admin/dashboard/{{$dashboard->id}}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="badge bg-danger border-0" onclick="return confirm('Lanjutkan Untuk Menghapus Data')"><box-icon name='trash' size='xs'></box-icon></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    <tfoot>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Dashboard</th>
                            <th class="text-center">Deskripsi</th>
                            <th class="text-center">Link Dashboard</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection
