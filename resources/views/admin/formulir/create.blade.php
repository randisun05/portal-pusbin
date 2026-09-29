@extends('layout.main-admin')

@section('container')

<div class="container-fluid">
    <h1 class="h3 mb-2 mt-5 text-center">Tambah Formulir</h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="/admin/formulir" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Formulir</label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
                    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi (opsional)</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="1" selected>Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan & Lanjut Tambah Field</button>
                <a href="/admin/formulir" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

@endsection
