@extends('layout.main-admin')

@section('container')

<div class="container-fluid">
    <h1 class="h3 mb-2 mt-5 text-center">Materi Paparan: {{ $kegiatan->nama }}</h1>

    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
     {{ session('success') }}
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 mt-2">
            Unggah Materi Paparan Baru
        </div>
        <div class="card-body">
            <form action="/admin/kegiatan/{{ $kegiatan->id }}/materi" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="judul" class="form-label">Judul Materi</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="file" class="form-label">Berkas (PDF/PPT/DOC)</label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" accept=".pdf,.ppt,.pptx,.doc,.docx">
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="keterangan" class="form-label">Keterangan (opsional)</label>
                        <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" value="{{ old('keterangan') }}">
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Unggah Materi</button>
                    <a href="/admin/kegiatan" class="btn btn-outline-secondary ms-2">Kembali ke Daftar Kegiatan</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header py-3 mt-2">
            Daftar Materi Paparan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Judul</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Berkas</th>
                            <th class="text-center">Diunggah</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($materis as $materi)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $materi->judul }}</td>
                            <td>{{ $materi->keterangan ?: '-' }}</td>
                            <td class="text-center"><a href="/storage/{{ $materi->file }}" target="_blank">Lihat Berkas</a></td>
                            <td class="text-center">{{ $materi->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                <form action="/admin/kegiatan/{{ $kegiatan->id }}/materi/{{ $materi->id }}" method="POST" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="badge bg-danger border-0" onclick="return confirm('Lanjutkan Hapus Materi Paparan')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="6">Belum ada materi paparan untuk kegiatan ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
