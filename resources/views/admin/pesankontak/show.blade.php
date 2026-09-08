@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Detail Pesan</h1>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th style="width: 150px;">Nama</th>
                    <td>{{$pesan->nama}}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{$pesan->email}}</td>
                </tr>
                <tr>
                    <th>Telepon</th>
                    <td>{{$pesan->telepon ?? '-'}}</td>
                </tr>
                <tr>
                    <th>Subjek</th>
                    <td>{{$pesan->subjek ?? '-'}}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{$pesan->created_at->format('d-m-Y H:i')}}</td>
                </tr>
                <tr>
                    <th>Pesan</th>
                    <td style="white-space: pre-line;">{{$pesan->pesan}}</td>
                </tr>
            </table>
            <div class="text-center mt-3">
                <a href="mailto:{{$pesan->email}}" class="btn btn-primary">Balas via Email</a>
                <a href="/admin/pesankontak" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
