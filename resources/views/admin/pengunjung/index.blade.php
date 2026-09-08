@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Monitoring Pengunjung</h1>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h3 class="mb-0">{{ number_format($totalViews) }}</h3>
                    <span class="text-muted">Total Kunjungan</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h3 class="mb-0">{{ number_format($todayViews) }}</h3>
                    <span class="text-muted">Kunjungan Hari Ini</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h3 class="mb-0">{{ number_format($todayUnique) }}</h3>
                    <span class="text-muted">Pengunjung Unik Hari Ini</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h3 class="mb-0">{{ number_format($weekUnique) }}</h3>
                    <span class="text-muted">Pengunjung Unik 7 Hari</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">Kunjungan 14 Hari Terakhir</div>
                <div class="card-body">
                    <div id="visitChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">Halaman Terpopuler</div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <tbody>
                            @forelse ($topPages as $page)
                                <tr>
                                    <td class="text-truncate" style="max-width: 200px;" title="{{ $page->path }}">{{ $page->path }}</td>
                                    <td class="text-end fw-bold">{{ $page->total }}</td>
                                </tr>
                            @empty
                                <tr><td class="text-center text-muted">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header">Sumber Kunjungan (Referrer)</div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <tbody>
                            @forelse ($topReferrers as $ref)
                                <tr>
                                    <td class="text-truncate" style="max-width: 300px;" title="{{ $ref->referrer }}">{{ $ref->referrer }}</td>
                                    <td class="text-end fw-bold">{{ $ref->total }}</td>
                                </tr>
                            @empty
                                <tr><td class="text-center text-muted">Belum ada referrer eksternal tercatat.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    var options = {
        chart: { type: 'area', height: 300, toolbar: { show: false } },
        series: [{ name: 'Kunjungan', data: @json($chartData) }],
        xaxis: { categories: @json($chartLabels) },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        colors: ['#696cff'],
    };
    var chart = new ApexCharts(document.querySelector('#visitChart'), options);
    chart.render();
});
</script>

@endsection
