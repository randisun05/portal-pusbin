<div class="form-group mt-4 ms-5 me-5">
    <div class="row row-cols-3 mb-4">
        <div class="col col-lg-2"><label for="nama">Nama Template</label></div>
        <div class="col">
            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" value="{{ old('nama', $template->nama ?? '') }}" placeholder="Misal: Template Ujikom">
            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="row row-cols-3 mb-4">
        <div class="col col-lg-2"><label for="warna_aksen">Warna Aksen</label></div>
        <div class="col d-flex align-items-center gap-2">
            <input type="color" class="form-control form-control-color" name="warna_aksen" id="warna_aksen" value="{{ old('warna_aksen', $template->warna_aksen ?? '#f92c24') }}" style="width: 60px;">
            @error('warna_aksen')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="row row-cols-3 mb-4">
        <div class="col col-lg-2"><label for="logo">Logo (opsional)</label></div>
        <div class="col">
            @if(!empty($template->logo))
                <div class="mb-2"><img src="{{ asset('storage/' . $template->logo) }}" alt="Logo" style="height: 48px;"></div>
            @endif
            <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" id="logo" accept=".jpg,.jpeg,.png">
            @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="row row-cols-3 mb-4">
        <div class="col col-lg-2"><label for="teks_pembuka">Teks Pembuka</label></div>
        <div class="col">
            <input type="text" class="form-control @error('teks_pembuka') is-invalid @enderror" name="teks_pembuka" id="teks_pembuka" value="{{ old('teks_pembuka', $template->teks_pembuka ?? 'Diberikan kepada:') }}">
            @error('teks_pembuka')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="row row-cols-3 mb-4">
        <div class="col col-lg-2"><label for="teks_keterangan">Teks Keterangan</label></div>
        <div class="col">
            <textarea class="form-control @error('teks_keterangan') is-invalid @enderror" name="teks_keterangan" id="teks_keterangan" rows="3">{{ old('teks_keterangan', $template->teks_keterangan ?? 'NIP {nip}, {jabatan} dari {instansi}, atas partisipasinya dalam kegiatan {kegiatan} yang diselenggarakan pada {waktu}.') }}</textarea>
            <small class="text-muted">Token yang tersedia: <code>{nama}</code> <code>{nip}</code> <code>{jabatan}</code> <code>{instansi}</code> <code>{kegiatan}</code> <code>{waktu}</code></small>
            @error('teks_keterangan')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="row row-cols-3 mb-4">
        <div class="col col-lg-2"><label for="nama_penandatangan">Nama Penandatangan</label></div>
        <div class="col">
            <input type="text" class="form-control @error('nama_penandatangan') is-invalid @enderror" name="nama_penandatangan" id="nama_penandatangan" value="{{ old('nama_penandatangan', $template->nama_penandatangan ?? '') }}">
            @error('nama_penandatangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="row row-cols-3 mb-4">
        <div class="col col-lg-2"><label for="jabatan_penandatangan">Jabatan Penandatangan</label></div>
        <div class="col">
            <input type="text" class="form-control @error('jabatan_penandatangan') is-invalid @enderror" name="jabatan_penandatangan" id="jabatan_penandatangan" value="{{ old('jabatan_penandatangan', $template->jabatan_penandatangan ?? '') }}">
            @error('jabatan_penandatangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="row row-cols-3 mb-4">
        <div class="col col-lg-2"><label for="tanda_tangan">Gambar Tanda Tangan (opsional)</label></div>
        <div class="col">
            @if(!empty($template->tanda_tangan))
                <div class="mb-2"><img src="{{ asset('storage/' . $template->tanda_tangan) }}" alt="Tanda Tangan" style="height: 48px;"></div>
            @endif
            <input type="file" class="form-control @error('tanda_tangan') is-invalid @enderror" name="tanda_tangan" id="tanda_tangan" accept=".jpg,.jpeg,.png">
            @error('tanda_tangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="row row-cols-3 mb-4">
        <div class="col col-lg-2"><label for="is_default">Jadikan Default</label></div>
        <div class="col">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="is_default" id="is_default" value="1" {{ old('is_default', $template->is_default ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_default">Gunakan template ini sebagai default saat menerbitkan sertifikat baru</label>
            </div>
        </div>
    </div>

    <div class="col text-center m-3">
        <button class="btn btn-lg btn-primary mt-3" type="submit">Simpan</button>
        <a href="/admin/sertifikat-template" class="btn btn-lg btn-secondary ms-4 mt-3">Batal</a>
    </div>
</div>
