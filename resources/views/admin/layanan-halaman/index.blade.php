@extends('layout.main-admin')

@section('container')
<div class="container-fluid">
    <h1 class="h3 mb-2 mt-5 text-center">Halaman Layanan (Menu Navbar)</h1>
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <a class="btn btn-primary" href="/admin/layanan-halaman/create"><i class="fas fa-plus me-2"></i>Tambah Halaman</a>
            <small class="text-muted">Halaman aktif tampil di menu <strong>Layanan</strong> pada navbar, sesuai urutan.</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">Urutan</th>
                            <th>Nama di Menu</th>
                            <th>Judul Halaman</th>
                            <th>URL</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($halamans as $halaman)
                        <tr>
                            <td class="text-center">{{ $halaman->urutan }}</td>
                            <td>{{ $halaman->nama }}</td>
                            <td>{{ $halaman->judul }}</td>
                            <td><a href="{{ $halaman->url }}" target="_blank">{{ $halaman->url }}</a></td>
                            <td class="text-center">
                                <span class="badge {{ $halaman->status ? 'bg-success' : 'bg-secondary' }}">{{ $halaman->status ? 'Aktif' : 'Non-aktif' }}</span>
                            </td>
                            <td class="text-center">
                                <a href="/admin/layanan-halaman/{{ $halaman->slug }}/edit" class="badge bg-warning"><i class="fas fa-edit"></i></a>
                                <form action="/admin/layanan-halaman/{{ $halaman->slug }}" method="POST" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="badge bg-danger border-0" onclick="return confirm('Lanjutkan untuk menghapus halaman ini?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted">Belum ada halaman layanan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
