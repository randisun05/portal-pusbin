@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Basis Pengetahuan (Chat AI)</h1>
    <p class="text-center text-muted">
        Materi di sini dipakai sebagai sumber jawaban otomatis widget chat AI di situs publik.
        Semakin lengkap isinya, semakin baik chat bisa menjawab pertanyaan pengunjung secara mandiri.
    </p>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
             {{ session('success') }}
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

    <!-- Main Content -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <a class="btn btn-primary" href="/admin/pengetahuan/create">Tambah Materi</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Judul</th>
                            <th class="text-center">Kategori</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Urutan</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($items as $item)
                    <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td>{{$item->judul}}</td>
                        <td class="text-center">{{$item->kategori ?? '-'}}</td>
                        <td class="text-center">
                            @if($item->aktif)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Non Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">{{$item->urutan}}</td>
                        <td class="text-center">
                            <a href="/admin/pengetahuan/{{$item->id}}/edit" class="badge bg-warning">Ubah</a>
                            <form action="/admin/pengetahuan/{{$item->id}}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="badge bg-danger border-0" onclick="return confirm('Lanjutkan Untuk Menghapus Data')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada materi pengetahuan. Tambahkan agar chat AI bisa menjawab lebih banyak pertanyaan.</td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
