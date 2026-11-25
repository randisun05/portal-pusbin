@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Detail Admin</h1>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th style="width: 150px;">Nama</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td>{{ $user->username }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td>{{ optional($user->role)->label ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Terdaftar Sejak</th>
                    <td>{{ $user->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            </table>
            <div class="text-center mt-3">
                <a href="/admin/register/{{ $user->id }}/edit" class="btn btn-warning">Ubah</a>
                <a href="/admin/register" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
