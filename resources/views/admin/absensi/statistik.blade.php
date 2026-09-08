@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Statistik Absensi</h1>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h3 class="mb-0">{{ number_format($total) }}</h3>
                    <span class="text-muted">Total Absensi Tercatat</span>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">Tren Absensi 14 Hari Terakhir</div>
                <div class="card-body">
                    <div id="trendChart"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header">Kegiatan dengan Kehadiran Terbanyak</div>
                <div class="card-body">
                    <div id="kegiatanChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header">Instansi dengan Kehadiran Terbanyak</div>
                <div class="card-body">
                    <div id="instansiChart"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    new ApexCharts(document.querySelector('#trendChart'), {
        chart: { type: 'area', height: 260, toolbar: { show: false } },
        series: [{ name: 'Absensi', data: @json($trendData) }],
        xaxis: { categories: @json($trendLabels) },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        colors: ['#71dd37'],
    }).render();

    new ApexCharts(document.querySelector('#kegiatanChart'), {
        chart: { type: 'bar', height: 300, toolbar: { show: false } },
        series: [{ name: 'Kehadiran', data: @json($perKegiatan->pluck('total')) }],
        xaxis: { categories: @json($perKegiatan->map(fn($k) => optional($k->kegiatan)->nama ?? '#' . $k->kegiatan_id)) },
        plotOptions: { bar: { horizontal: true } },
        colors: ['#696cff'],
    }).render();

    new ApexCharts(document.querySelector('#instansiChart'), {
        chart: { type: 'bar', height: 300, toolbar: { show: false } },
        series: [{ name: 'Kehadiran', data: @json($perInstansi->pluck('total')) }],
        xaxis: { categories: @json($perInstansi->pluck('instansi')) },
        plotOptions: { bar: { horizontal: true } },
        colors: ['#ffab00'],
    }).render();
});
</script>

@endsection
