@extends('layout.main-admin')

@section('container')

 <!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Daftar Usul Konsultasi Online</h1>
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
     {{ session('success') }}
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                             <th class="text-center">Tiket</th>
                            <th class="text-center">nip</th>
                            <th class="text-center">perihal</th>
                            <th class="text-center">jadwal</th>
                            <th class="text-center">Action</th>
                            <th class="text-center">Jadwal Fix</th>
                            <th class="text-center">Link</th>
                            <th class="text-center">PIC</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    @foreach ($konsultasis as $konsultasi )
                    <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td>{{$konsultasi->tiket}}</td>
                        <td>{{$konsultasi->nip}}</td>
                        <td>{{$konsultasi->perihal}}</td>
                        <td>{{$konsultasi->jadwal}}</td>
                        <td class="text-center">
                            <a href="/admin/konsultasi/{{$konsultasi->id}}/edit" class="badge bg-warning">Jawab</a>
                            <form action="/admin/konsultasi/{{$konsultasi->id}}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="badge bg-danger border-0" onclick="return confirm('Lanjutkan Untuk Menghapus Data')"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                </svg></button>
                            </form>
                        </td>
                        <td>{{$konsultasi->jadwalfix}}</td>
                        <td>{{$konsultasi->link}}</td>
                        <td>{{$konsultasi->pic}}</td>
                        <td>{{$konsultasi->keterangan}}</td>
                        <td>{{$konsultasi->status}}</td>
                    </tr>
                    @endforeach
                    <tfoot>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tiket</th>
                            <th class="text-center">nip</th>
                            <th class="text-center">perihal</th>
                            <th class="text-center">jadwal</th>
                            <th class="text-center">Action</th>
                            <th class="text-center">Jadwal Fix</th>
                            <th class="text-center">Link</th>
                            <th class="text-center">PIC</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
