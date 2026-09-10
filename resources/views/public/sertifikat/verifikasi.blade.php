@extends('layout.main-main')
@section('container')
@include('layout.web.nav')

<main>
@include('layout.web.header-detail')

<div class="container-fluid">
    <div class="row py-5">
        <div class="col-md-6 offset-md-3 py-4">
            <h4 class="mb-3 text-center">Verifikasi Keaslian Sertifikat</h4>
            <p class="text-center text-muted mb-4">Masukkan nomor sertifikat yang tertera pada dokumen untuk memastikan keasliannya.</p>

            <form class="mb-4" action="/verifikasi-sertifikat" method="get">
                <label for="nomor" class="form-label">Nomor Sertifikat</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="nomor" name="nomor" placeholder="Contoh: SERT/2026/00001" required value="{{ $nomor }}">
                    <button type="submit" class="btn btn-primary" id="kirim">CEK</button>
                </div>
            </form>

            @if ($sertifikat)
                <div class="card shadow-sm border-success">
                    <div class="card-body">
                        <h5 class="card-title text-success mb-3">✔ Sertifikat Valid</h5>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th style="width: 40%;">Nomor Sertifikat</th>
                                <td>{{ $sertifikat->nomor_sertifikat }}</td>
                            </tr>
                            <tr>
                                <th>Nama Peserta</th>
                                <td>{{ $sertifikat->absensi->nama }}</td>
                            </tr>
                            <tr>
                                <th>NIP</th>
                                <td>{{ $sertifikat->absensi->nip }}</td>
                            </tr>
                            <tr>
                                <th>Instansi</th>
                                <td>{{ $sertifikat->absensi->instansi }}</td>
                            </tr>
                            <tr>
                                <th>Kegiatan</th>
                                <td>{{ optional($sertifikat->absensi->kegiatan)->nama }}</td>
                            </tr>
                            <tr>
                                <th>Waktu Pelaksanaan</th>
                                <td>{{ optional($sertifikat->absensi->kegiatan)->waktu }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Terbit</th>
                                <td>{{ $sertifikat->created_at->format('d-m-Y') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            @elseif ($notFound)
                <div class="alert alert-danger text-center">
                    ✘ Sertifikat dengan nomor <strong>{{ $nomor }}</strong> tidak ditemukan. Pastikan nomor sertifikat yang dimasukkan sudah benar.
                </div>
            @endif
        </div>
    </div>
</div>
</main>

@include('layout.web.footer')
@endsection
