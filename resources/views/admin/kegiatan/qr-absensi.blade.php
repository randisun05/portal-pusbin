@extends('layout.main-admin')

@section('container')

<style>
    @media print {
        .navbar, .sidebar-wrapper, .btn, .no-print { display: none !important; }
        .content-wrapper { margin: 0 !important; }
    }
</style>

<div class="container-fluid">
    <h1 class="h3 mb-2 mt-5 text-center">QR Absensi: {{ $kegiatan->nama }}</h1>
    <p class="text-center text-muted no-print">
        Cetak atau tampilkan di layar saat acara berlangsung. Peserta tinggal scan pakai kamera HP untuk langsung
        masuk ke form absensi kegiatan ini.
    </p>

    <div class="card shadow" style="max-width: 500px; margin: 0 auto;">
        <div class="card-body text-center py-5">
            <img src="{{ $qrCodeDataUri }}" alt="QR Absensi {{ $kegiatan->nama }}" class="img-fluid mb-3" style="max-width: 300px;">
            <h5 class="mb-1">{{ $kegiatan->nama }}</h5>
            <p class="text-muted small mb-4">{{ $kegiatan->waktu }}</p>
            <p class="small text-muted">{{ url('/absensi/' . $kegiatan->slug) }}</p>

            <div class="no-print mt-3">
                <button class="btn btn-primary" onclick="window.print()"><i class="bi bi-printer"></i> Cetak</button>
                <a href="/admin/kegiatan" class="btn btn-outline-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>

@endsection
