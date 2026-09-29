@extends('layout.main-admin')

@section('container')

<div class="container-fluid">
    <h1 class="h3 mb-2 mt-5 text-center">Kelola Field — {{ $formulir->judul }}</h1>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">Daftar Field</div>
                <div class="card-body">
                    @if ($fields->isEmpty())
                        <p class="text-muted mb-0">Belum ada field. Tambahkan di sebelah kanan.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Label</th>
                                    <th>Tipe</th>
                                    <th class="text-center">Wajib</th>
                                    <th class="text-center">Urutan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fields as $field)
                                <tr>
                                    <td>{{ $field->label }}</td>
                                    <td>{{ $tipeList[$field->tipe] ?? $field->tipe }}</td>
                                    <td class="text-center">{{ $field->wajib ? 'Ya' : 'Tidak' }}</td>
                                    <td class="text-center">
                                        <form action="/admin/formulir/{{ $formulir->id }}/field/{{ $field->id }}/naik" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-secondary" title="Naik">&uarr;</button>
                                        </form>
                                        <form action="/admin/formulir/{{ $formulir->id }}/field/{{ $field->id }}/turun" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-secondary" title="Turun">&darr;</button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <form action="/admin/formulir/{{ $formulir->id }}/field/{{ $field->id }}" method="POST" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="badge bg-danger border-0" onclick="return confirm('Hapus field ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            <a href="/admin/formulir" class="btn btn-secondary">Kembali ke Daftar Formulir</a>
            <a href="/form/{{ $formulir->slug }}" target="_blank" class="btn btn-outline-primary">Lihat Form Publik</a>
        </div>

        <div class="col-lg-5">
            <div class="card shadow">
                <div class="card-header py-3">Tambah Field</div>
                <div class="card-body">
                    <form action="/admin/formulir/{{ $formulir->id }}/field" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="label" class="form-label">Label Field</label>
                            <input type="text" class="form-control @error('label') is-invalid @enderror" id="label" name="label" value="{{ old('label') }}" required>
                            @error('label')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="tipe" class="form-label">Tipe Field</label>
                            <select class="form-select @error('tipe') is-invalid @enderror" id="tipe" name="tipe">
                                @foreach ($tipeList as $value => $label)
                                    <option value="{{ $value }}" {{ old('tipe') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('tipe')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3" id="opsiWrap" style="display: none;">
                            <label for="opsi" class="form-label">Daftar Pilihan (satu per baris)</label>
                            <textarea class="form-control @error('opsi') is-invalid @enderror" id="opsi" name="opsi" rows="4" placeholder="Pilihan 1&#10;Pilihan 2&#10;Pilihan 3">{{ old('opsi') }}</textarea>
                            @error('opsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="wajib" name="wajib" value="1" {{ old('wajib') ? 'checked' : '' }}>
                            <label class="form-check-label" for="wajib">Wajib diisi</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah Field</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var tipeSelect = document.getElementById('tipe');
        var opsiWrap = document.getElementById('opsiWrap');
        var tipeBerOpsi = @json($tipeBerOpsi);

        function toggleOpsi() {
            opsiWrap.style.display = tipeBerOpsi.includes(tipeSelect.value) ? 'block' : 'none';
        }

        tipeSelect.addEventListener('change', toggleOpsi);
        toggleOpsi();
    })();
</script>

@endsection
