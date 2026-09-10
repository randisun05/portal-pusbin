@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Statistik Konsultasi</h1>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h3 class="mb-0">{{ number_format($total) }}</h3>
                    <span class="text-muted">Total Tiket Konsultasi</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div id="statusChart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">Tren Tiket Masuk 14 Hari Terakhir</div>
                <div class="card-body">
                    <div id="trendChart"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header">Jenis Isu Konsultasi Terbanyak</div>
                <div class="card-body">
                    <div id="jenisChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header">Instansi Paling Aktif Berkonsultasi</div>
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
    new ApexCharts(document.querySelector('#statusChart'), {
        chart: { type: 'donut', height: 220 },
        series: [{{ $terjawab }}, {{ $belumTerjawab }}],
        labels: ['Terjawab', 'Belum Terjawab'],
        colors: ['#71dd37', '#ff3e1d'],
        legend: { position: 'bottom' },
    }).render();

    new ApexCharts(document.querySelector('#trendChart'), {
        chart: { type: 'area', height: 260, toolbar: { show: false } },
        series: [{ name: 'Tiket', data: @json($trendData) }],
        xaxis: { categories: @json($trendLabels) },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        colors: ['#696cff'],
    }).render();

    new ApexCharts(document.querySelector('#jenisChart'), {
        chart: { type: 'bar', height: 300, toolbar: { show: false } },
        series: [{ name: 'Tiket', data: @json($perJenis->pluck('total')) }],
        xaxis: { categories: @json($perJenis->map(fn($k) => optional($k->kode_konsultasi)->jenis ?? '#' . $k->kode_id)) },
        plotOptions: { bar: { horizontal: true } },
        colors: ['#ffab00'],
    }).render();

    new ApexCharts(document.querySelector('#instansiChart'), {
        chart: { type: 'bar', height: 300, toolbar: { show: false } },
        series: [{ name: 'Tiket', data: @json($perInstansi->pluck('total')) }],
        xaxis: { categories: @json($perInstansi->pluck('instansi')) },
        plotOptions: { bar: { horizontal: true } },
        colors: ['#03c3ec'],
    }).render();
});
</script>

@endsection
