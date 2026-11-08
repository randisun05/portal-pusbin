@php $h = $halaman ?? null; @endphp
<div class="row mb-4">
    <div class="col-lg-2"><label for="nama">Nama di Menu</label></div>
    <div class="col-lg-6">
        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" value="{{ old('nama', $h?->nama) }}" placeholder="mis. Uji Kompetensi JFK" required>
        <div class="form-text">Teks yang tampil pada menu Layanan di navbar.</div>
        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-2"><label for="judul">Judul Halaman</label></div>
    <div class="col-lg-6">
        <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" id="judul" value="{{ old('judul', $h?->judul) }}" placeholder="mis. Uji Kompetensi Jabatan Fungsional Kepegawaian" required>
        <div class="form-text">Judul besar &amp; breadcrumb di halaman layanan.</div>
        @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-2"><label for="slug">Slug (URL)</label></div>
    <div class="col-lg-6">
        <div class="input-group">
            <span class="input-group-text">/layanan/</span>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" id="slug" value="{{ old('slug', $h?->slug) }}" placeholder="dibuat otomatis dari nama bila kosong">
        </div>
        @error('slug')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-2"><label for="urutan">Urutan</label></div>
    <div class="col-lg-2">
        <input type="number" min="0" class="form-control @error('urutan') is-invalid @enderror" name="urutan" id="urutan" value="{{ old('urutan', $h?->urutan ?? $nextUrutan ?? 0) }}" required>
        @error('urutan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-lg-1"><label for="status">Status</label></div>
    <div class="col-lg-3">
        <select class="form-select" name="status" id="status">
            <option value="1" {{ old('status', $h?->status ?? 1) ? 'selected' : '' }}>Aktif (tampil di menu)</option>
            <option value="0" {{ old('status', $h?->status ?? 1) ? '' : 'selected' }}>Non-aktif</option>
        </select>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-2"><label for="konten">Isi Halaman</label></div>
    <div class="col-lg-10">
        <input type="hidden" name="konten" id="konten" value="{{ old('konten', $h?->konten) }}">
        <trix-editor input="konten" placeholder="Tulis isi halaman layanan"></trix-editor>
        @error('konten')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
</div>

<script>
    document.addEventListener('trix-file-accept', function (e) { e.preventDefault(); });
</script>
