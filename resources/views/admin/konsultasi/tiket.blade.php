@extends('layout.main-admin')
@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Daftar Tiket Konsultasi</h1>
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
     {{ session('success') }}
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow">
        <div class="card-header py-3">
            <form class="row g-2" method="GET" action="/admin/konsultasi-tiket">
                <div class="col-auto">
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Cari tiket, nama, atau NIP...">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tiket</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">NIP</th>
                            <th class="text-center">Jenis Konsultasi</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    @forelse ($tikets as $tiket)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $tiket->tiket }}</td>
                        <td>{{ $tiket->nama }}</td>
                        <td>{{ $tiket->nip }}</td>
                        <td>{{ optional($tiket->kode_konsultasi)->jenis ?? '-' }}</td>
                        <td class="text-center">
                            @if($tiket->jawab)
                                <span class="badge bg-success">Sudah Dijawab</span>
                            @else
                                <span class="badge bg-warning">Belum Dijawab</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="/admin/konsultasi/{{ $tiket->id }}/edit" class="badge bg-primary">{{ $tiket->jawab ? 'Lihat/Ubah' : 'Jawab' }}</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada tiket konsultasi.</td>
                    </tr>
                    @endforelse
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $tikets->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
