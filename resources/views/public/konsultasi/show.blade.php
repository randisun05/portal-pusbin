@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.web.header-detail')
@include('layout.partial.notif')


<!-- Form Show Konsultasi -->
<main>
<section class="section">
@if ($konsultasi != null)
    @if ($konsultasi->jawab == 1)
    <div class="container">
        <div class="col-md-6 offset-md-3 card">
            <div class="card-header">
            <h5 class="mb-0">Jadwal Konsultasi</h5>
            </div>
            <dl class="row mb-0 p-3">
                <dt class="col-sm-4">NIP Pengusul</dt>
                <dd class="col-sm-8 text-break">{{ $konsultasi->nip }}</dd>
                <dt class="col-sm-4">Perihal Konsultasi</dt>
                <dd class="col-sm-8 text-break">{{ optional($konsultasi->kode_konsultasi)->jenis }}</dd>
                <dt class="col-sm-4">Jadwal Konsultasi</dt>
                <dd class="col-sm-8 text-break">{{ $konsultasi->jadwalfix }}</dd>
                <dt class="col-sm-4">Link Konsultasi</dt>
                <dd class="col-sm-8 text-break">{{ $konsultasi->link }}</dd>
                <dt class="col-sm-4">Person In Charge</dt>
                <dd class="col-sm-8 text-break">{{ $konsultasi->pic }}</dd>
                <dt class="col-sm-4">Keterangan</dt>
                <dd class="col-sm-8 text-break">{{ $konsultasi->keterangan }}</dd>
            </dl>
        </div>
    </div>
    @elseif ($konsultasi->jawab == 0)
    <div class="container">
        <p class="text-center fs-4">Tiket Belum Dijawab</p>
    </div>
    @endif
    @else
<div class="container">
    <p class="text-center fs-4">Tiket Usul Tidak Tersedia</p>
</div>
@endif

                <div class="text-center mt-4">
                    <a href="/konsultasi/cari" class="btn btn-outline-secondary">Kembali</a>
                </div>
</section>
</main>
@include('layout.web.footer')

@endsection
