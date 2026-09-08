@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Daftar FAQ</h1>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
             {{ session('success') }}
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

    <!-- Main Content -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <a class="btn btn-primary" href="/admin/faq/create">Tambah FAQ</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Pertanyaan</th>
                            <th class="text-center">Kategori</th>
                            <th class="text-center">Urutan</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    @forelse ($faqs as $faq)
                    <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td>{{$faq->pertanyaan}}</td>
                        <td class="text-center">{{$faq->kategori ?? '-'}}</td>
                        <td class="text-center">{{$faq->urutan}}</td>
                        <td class="text-center">
                            <a href="/admin/faq/{{$faq->id}}/edit" class="badge bg-warning">Ubah</a>
                            <form action="/admin/faq/{{$faq->id}}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="badge bg-danger border-0" onclick="return confirm('Lanjutkan Untuk Menghapus Data')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada FAQ.</td>
                    </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
