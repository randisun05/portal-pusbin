@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Pesan Masuk (Kontak Kami)</h1>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
             {{ session('success') }}
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

    <!-- Main Content -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Subjek</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    @forelse ($pesans as $pesan)
                    <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td class="text-center">
                            @if($pesan->dibaca)
                                <span class="badge bg-secondary">Sudah Dibaca</span>
                            @else
                                <span class="badge bg-primary">Baru</span>
                            @endif
                        </td>
                        <td>{{$pesan->nama}}</td>
                        <td>{{$pesan->email}}</td>
                        <td>{{$pesan->subjek ?? '-'}}</td>
                        <td class="text-center">{{$pesan->created_at->format('d-m-Y H:i')}}</td>
                        <td class="text-center">
                            <a href="/admin/pesankontak/{{$pesan->id}}" class="badge bg-info">Lihat</a>
                            <form action="/admin/pesankontak/{{$pesan->id}}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="badge bg-danger border-0" onclick="return confirm('Lanjutkan Untuk Menghapus Data')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada pesan masuk.</td>
                    </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->


@endsection
