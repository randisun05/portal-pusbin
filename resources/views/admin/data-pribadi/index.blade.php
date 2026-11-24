@extends('layout.main-admin')

@section('container')
<div class="container-fluid">
    <h1 class="h3 mb-2 mt-5 text-center">Ekspor Data Pribadi</h1>
    <p class="text-center text-muted">Unduh seluruh data yang tersimpan untuk satu NIP (absensi, konsultasi, jawaban survei, sertifikat). Setiap ekspor dan anonimisasi tercatat di Audit Trail.</p>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="/admin/data-pribadi" class="row g-2 align-items-end">
                <div class="col-md-6">
                    <label for="nip" class="form-label">NIP (18 digit)</label>
                    <input type="text" name="nip" id="nip" inputmode="numeric" maxlength="18" pattern="[0-9]{18}" title="NIP 18 digit angka"
                           class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip', $nip) }}" required>
                    @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-auto"><button class="btn btn-primary" type="submit">Cari</button></div>
            </form>
        </div>
    </div>

    @if($ringkasan)
    <div class="card shadow mb-4">
        <div class="card-header py-3"><strong>Data untuk NIP {{ mask_nip($nip) }}</strong></div>
        <div class="card-body">
            <table class="table table-bordered w-auto">
                <tr><th>Absensi</th><td>{{ $ringkasan['absensi'] }}</td></tr>
                <tr><th>Konsultasi</th><td>{{ $ringkasan['konsultasi'] }}</td></tr>
                <tr><th>Jawaban survei</th><td>{{ $ringkasan['jawaban_survei'] }}</td></tr>
                <tr><th>Sertifikat</th><td>{{ $ringkasan['sertifikat'] }}</td></tr>
            </table>
            <form method="POST" action="/admin/data-pribadi/export">
                @csrf
                <input type="hidden" name="nip" value="{{ $nip }}">
                <button class="btn btn-success" type="submit">Unduh XLSX</button>
            </form>
            <hr>
            <h2 class="h6 text-danger">Anonimisasi data</h2>
            <p class="small text-muted">Mengganti NIP, nama, email, jabatan, instansi, dan saran pada absensi, konsultasi, dan jawaban survei NIP ini dengan penanda anonim. Baris, nomor sertifikat, dan statistik tetap ada. Tindakan ini tidak dapat dibatalkan; unduh ekspor lebih dulu bila perlu arsip. Teks jawaban tiket dan isi sertifikat yang sudah diterbitkan tidak diubah.</p>
            <form method="POST" action="/admin/data-pribadi/anonimkan" class="row g-2 align-items-end">
                @csrf
                <input type="hidden" name="nip" value="{{ $nip }}">
                <div class="col-md-6">
                    <label for="konfirmasi" class="form-label">Ketik <strong>ANONIMKAN</strong> untuk konfirmasi</label>
                    <input type="text" name="konfirmasi" id="konfirmasi" class="form-control @error('konfirmasi') is-invalid @enderror" autocomplete="off" required>
                    @error('konfirmasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-auto"><button class="btn btn-danger" type="submit">Anonimkan</button></div>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection
