@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Template Sertifikat</h1>
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
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
          <a class="btn btn-primary" href="/admin/sertifikat-template/create">Tambah Template</a>
          <a class="btn btn-outline-secondary" href="/admin/pengaturan-sertifikat">Pengaturan Nomor Sertifikat</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Logo</th>
                            <th>Nama Template</th>
                            <th class="text-center">Warna</th>
                            <th class="text-center">Default</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    @forelse ($templates as $template)
                    <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td class="text-center">
                            @if($template->logo)
                                <img src="{{ asset('storage/' . $template->logo) }}" alt="Logo" style="height: 32px;">
                            @else
                                -
                            @endif
                        </td>
                        <td>{{$template->nama}}</td>
                        <td class="text-center">
                            <span style="display:inline-block; width:18px; height:18px; border-radius:4px; background: {{ $template->warna_aksen }}; vertical-align:middle;"></span>
                        </td>
                        <td class="text-center">
                            @if($template->is_default)
                                <span class="badge bg-success">Default</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="/admin/sertifikat-template/{{$template->id}}/edit" class="badge bg-warning">Ubah</a>
                            <form action="/admin/sertifikat-template/{{$template->id}}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="badge bg-danger border-0" onclick="return confirm('Lanjutkan Untuk Menghapus Data')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">Belum ada template sertifikat.</td></tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
