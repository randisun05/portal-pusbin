@extends('layout.main-admin')

@section('container')

<div class="container-fluid">
    <h1 class="h3 mb-2 mt-5 text-center">Daftar Formulir</h1>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-header py-3 mt-2">
            <a class="btn btn-primary" href="/admin/formulir/create">Tambah Formulir</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Judul</th>
                            <th class="text-center">Slug</th>
                            <th class="text-center">Jumlah Field</th>
                            <th class="text-center">Jumlah Submission</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($formulirs as $formulir)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $formulir->judul }}</td>
                            <td><code>/form/{{ $formulir->slug }}</code></td>
                            <td class="text-center">{{ $formulir->fields_count }}</td>
                            <td class="text-center">{{ $formulir->submissions_count }}</td>
                            <td class="text-center">
                                @if($formulir->status === '1')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="/admin/formulir/{{ $formulir->id }}/field" class="badge bg-info text-decoration-none">Kelola Field</a>
                                <a href="/admin/formulir/{{ $formulir->id }}/submissions" class="badge bg-primary text-decoration-none">Lihat Submission</a>
                                <a href="/admin/formulir/{{ $formulir->id }}/edit" class="badge bg-warning text-decoration-none">Edit</a>
                                <form action="/admin/formulir/{{ $formulir->id }}" method="POST" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="badge bg-danger border-0" onclick="return confirm('Yakin hapus formulir ini? Semua field & submission ikut terhapus.')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada formulir.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
