@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Role &amp; Permission</h1>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
             {{ session('success') }}
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
             {{ session('error') }}
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

    <!-- Main Content -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Role</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Jumlah Admin</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    @foreach ($roles as $role)
                    <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td>{{$role->label}}</td>
                        <td>{{$role->deskripsi}}</td>
                        <td class="text-center">{{$role->users_count}}</td>
                        <td class="text-center">
                            @if($role->name === \App\Models\Role::SUPER_ADMIN)
                                <span class="text-muted small">Akses penuh (tidak dapat diubah)</span>
                            @else
                                <a href="/admin/role/{{$role->id}}/edit" class="badge bg-warning">Atur Permission</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
