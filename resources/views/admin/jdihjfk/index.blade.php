@extends('layout.main-admin')

@section('container')

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Repository JF MASN</h1>
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
     {{ session('success') }}
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <p class="text-center text-muted">Dokumen berstatus <strong>Publikasikan</strong> tampil di halaman Repository publik. Dokumen berstatus <strong>Internal</strong> tidak tampil publik, tapi tetap dipakai sebagai pengetahuan oleh chat AI.</p>

    <!-- Main Content -->
    <div class="card shadow">
        <div class="card-header py-3 mt-2">
          <a  class="btn btn-primary" href="/admin/repository/create">Tambah Dokumen Repository</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Deskripsi</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    @foreach ($datas as $data )
                    <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td>{{$data->title}}</td>
                        <td>{{ \Illuminate\Support\Str::limit($data->deskripsi, 120) }}</td>
                        <td class="text-center">
                            @if($data->status === 'published')
                                <span class="badge bg-success">Publikasikan</span>
                            @else
                                <span class="badge bg-secondary">Internal</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="/admin/repository/{{$data->id}}/edit" class="badge bg-warning"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg>
                            </a>
                            <form action="/admin/repository/{{$data->id}}" method="POST" class="d-inline">
                          @method('delete')
                          @csrf
                          <button class="badge bg-danger border-0" onclick="return confirm('Lanjutkan Hapus Dokumen')"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                </svg></button>
                           </form>
                          </td>
                          </tr>
                    @endforeach
                    <tfoot>
                        <tr>
                           <th class="text-center">No</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Deskripsi</th>
                            <th class="text-center">Status</th>
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
