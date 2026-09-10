@extends('layout.main-admin')

@section('container')

<style>
    .sk-hero { background: linear-gradient(135deg, #f92c24, #fd346e); border-radius: 18px; padding: 28px; color: #fff; }
    .sk-hero .sk-predikat-badge { display: inline-block; padding: 6px 16px; border-radius: 999px; font-weight: 700; font-size: .85rem; background: rgba(255,255,255,.18); }
    .sk-stat-card { border-radius: 16px; height: 100%; }
    .sk-callout { border-radius: 14px; padding: 16px 18px; }
    .sk-callout.sk-good { background: #71dd371a; border: 1px solid #71dd3755; }
    .sk-callout.sk-bad { background: #ff3e1d1a; border: 1px solid #ff3e1d55; }
    .sk-callout .sk-callout-title { font-size: .78rem; text-transform: uppercase; letter-spacing: .04em; font-weight: 700; color: #6c7382; }
</style>

<!-- Begin Page Content -->
<div class="container-fluid">

    <h1 class="h3 mb-2 mt-5 text-center">📊 Dashboard Survei Kepuasan</h1>
    <p class="text-center text-muted mb-4">Rekap interaktif Indeks Kepuasan Masyarakat (IKM) atas layanan Direktorat JF MASN.</p>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form class="row g-2" method="GET" action="/admin/survei-kepuasan">
                <div class="col-auto">
                    <select name="survei" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Pilih Survei Kepuasan --</option>
                        @foreach ($surveis as $survei)
                            <option value="{{ $survei->id }}" {{ optional($selected)->id === $survei->id ? 'selected' : '' }}>
                                {{ $survei->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
            @if($surveis->isEmpty())
                <p class="text-muted mb-0 mt-3">Belum ada survei bertipe skala kepuasan (tipe 3 atau 4).</p>
            @endif
        </div>
    </div>

    @if($selected)
        @if($totalResponden === 0)
            <div class="alert alert-warning">Survei ini belum memiliki responden.</div>
        @else
            <div class="row g-4 mb-4">
                <div class="col-lg-4">
                    <div class="sk-hero h-100">
                        <div class="text-uppercase" style="opacity:.85; font-size:.8rem; letter-spacing:.05em;">Indeks Kepuasan Keseluruhan</div>
                        <div class="d-flex align-items-end gap-2 mt-1">
                            <h1 class="mb-0" style="font-size:3rem; font-weight:800;">{{ $overallIndex }}</h1>
                            <span style="font-size:1.2rem; opacity:.85;">/ 100</span>
                        </div>
                        <div class="mt-2"><span class="sk-predikat-badge">{{ $predikat['label'] }}</span></div>
                        <div class="mt-3" style="opacity:.9; font-size:.85rem;">{{ number_format($totalResponden) }} responden telah mengisi survei ini</div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm sk-stat-card">
                        <div class="card-body">
                            <div class="card-header bg-transparent border-0 px-0 pt-0">Sebaran Sentimen Jawaban</div>
                            <div id="sentimentChart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex flex-column gap-3 h-100">
                        <div class="sk-callout sk-good">
                            <div class="sk-callout-title">🏆 Indikator Terbaik</div>
                            <div class="fw-bold">{{ optional($terbaik)['indikator'] }}</div>
                            <div class="text-muted small">Indeks {{ optional($terbaik)['index'] }}</div>
                        </div>
                        <div class="sk-callout sk-bad">
                            <div class="sk-callout-title">⚠️ Perlu Perhatian</div>
                            <div class="fw-bold">{{ optional($perluPerhatian)['indikator'] }}</div>
                            <div class="text-muted small">Indeks {{ optional($perluPerhatian)['index'] }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="card shadow-sm">
                        <div class="card-header">Indeks per Indikator</div>
                        <div class="card-body">
                            <div id="indikatorChart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card shadow-sm">
                        <div class="card-header">Tren Responden 14 Hari Terakhir</div>
                        <div class="card-body">
                            <div id="trendChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>

<!-- End of Main Content -->

@if($selected && $totalResponden > 0)
<script>
document.addEventListener('DOMContentLoaded', function () {
    @php
        $scaleLabels = $scaleMax === 4
            ? [1 => '😠 Tidak Memuaskan', 2 => '😕 Kurang Memuaskan', 3 => '🙂 Memuaskan', 4 => '😄 Sangat Memuaskan']
            : [1 => '😞 Tidak Memuaskan', 2 => '😐 Cukup Memuaskan', 3 => '😄 Sangat Memuaskan'];
    @endphp

    new ApexCharts(document.querySelector('#sentimentChart'), {
        chart: { type: 'donut', height: 240 },
        series: @json($sentiment->values()),
        labels: @json($sentiment->keys()->map(fn($k) => $scaleLabels[(int) $k] ?? $k)->values()),
        colors: ['#ff3e1d', '#ffab00', '#03c3ec', '#71dd37'],
        legend: { position: 'bottom', fontSize: '11px' },
    }).render();

    new ApexCharts(document.querySelector('#indikatorChart'), {
        chart: { type: 'bar', height: 320, toolbar: { show: false } },
        plotOptions: { bar: { horizontal: true, distributed: true } },
        legend: { show: false },
        series: [{ name: 'Indeks', data: @json($indikatorStats->pluck('index')) }],
        xaxis: { categories: @json($indikatorStats->pluck('indikator')), max: 100 },
        colors: @json($indikatorStats->pluck('color')),
        dataLabels: { formatter: function (val) { return val + ''; } },
    }).render();

    new ApexCharts(document.querySelector('#trendChart'), {
        chart: { type: 'area', height: 320, toolbar: { show: false } },
        series: [{ name: 'Responden', data: @json($trendData) }],
        xaxis: { categories: @json($trendLabels) },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        colors: ['#fd346e'],
    }).render();
});
</script>
@endif

@endsection
