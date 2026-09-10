@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Statistik Survei</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-header py-3">
            <form class="row g-2" method="GET" action="/admin/survei-statistik">
                <div class="col-auto">
                    <select name="survei" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Pilih Survei --</option>
                        @foreach ($surveis as $survei)
                            <option value="{{ $survei->id }}" {{ optional($selected)->id === $survei->id ? 'selected' : '' }}>
                                {{ $survei->title }} ({{ $survei->jumlah_responden }} responden)
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Judul Survei</th>
                            <th class="text-center">Jumlah Responden</th>
                        </tr>
                    </thead>
                    @forelse ($surveis as $survei)
                        <tr>
                            <td>{{ $survei->title }}</td>
                            <td class="text-center">{{ $survei->jumlah_responden }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-center">Belum ada survei.</td></tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header py-3">🏆 Leaderboard Kontributor Survei Teraktif</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">Peringkat</th>
                            <th>NIP</th>
                            <th class="text-center">Jumlah Survei Diisi</th>
                            <th class="text-center">Badge</th>
                        </tr>
                    </thead>
                    @forelse ($leaderboard as $row)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $row->nip }}</td>
                            <td class="text-center">{{ $row->jumlah }}</td>
                            <td class="text-center">{{ $row->badge['icon'] }} {{ $row->badge['label'] }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">Belum ada kontributor.</td></tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>

    @if($selected)
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Hasil: {{ $selected->title }}</h4>
            <a href="/admin/survei-statistik/{{ $selected->id }}/export" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
        <div class="row g-4">
            @forelse ($indikatorStats as $i => $stat)
                <div class="col-lg-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header">{{ $stat['indikator'] }}</div>
                        <div class="card-body">
                            @if($stat['type'] === 'chart')
                                <div id="chart-{{ $i }}"></div>
                            @else
                                @if($stat['answers']->isEmpty())
                                    <p class="text-muted mb-0">Belum ada jawaban.</p>
                                @else
                                    <ul class="mb-0" style="max-height: 220px; overflow-y: auto;">
                                        @foreach ($stat['answers'] as $answer)
                                            <li>{{ $answer }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">Survei ini belum memiliki indikator/jawaban.</p>
                </div>
            @endforelse
        </div>
    @endif
</div>

<!-- End of Main Content -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    @foreach ($indikatorStats as $i => $stat)
        @if($stat['type'] === 'chart' && $stat['labels']->isNotEmpty())
            new ApexCharts(document.querySelector('#chart-{{ $i }}'), {
                chart: { type: 'pie', height: 260 },
                series: @json($stat['values']),
                labels: @json($stat['labels']),
            }).render();
        @endif
    @endforeach
});
</script>

@endsection
