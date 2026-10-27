<?php

namespace App\Http\Controllers\Admin;

use App\Models\Survei;
use App\Models\SurveiGroup;
use App\Models\SurveiPublic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminSurveiKepuasanController extends Controller
{
    /**
     * Dashboard khusus untuk survei bertipe skala kepuasan (tipe 3 & 4):
     * indeks kepuasan keseluruhan, sebaran sentimen, dan performa per
     * indikator, disajikan lebih visual dibanding halaman statistik umum.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $surveis = Survei::whereIn('type', [3, 4])->orderBy('title')->get();

        $selected = null;
        $totalResponden = 0;
        $overallIndex = null;
        $predikat = null;
        $indikatorStats = collect();
        $sentiment = collect();
        $scaleMax = 4;
        $trendLabels = collect();
        $trendData = collect();
        $terbaik = null;
        $perluPerhatian = null;

        if ($request->survei) {
            $selected = Survei::whereIn('type', [3, 4])->find($request->survei);
        }

        if ($selected) {
            $scaleMax = (int) $selected->type;

            $groups = SurveiGroup::with('indikator')->where('survei_id', $selected->id)->get();
            $answers = SurveiPublic::where('survei_id', $selected->id)->get(['indikator_id', 'nip', 'velue']);

            $totalResponden = $answers->pluck('nip')->unique()->count();

            if ($answers->isNotEmpty()) {
                $rataRata = $answers->avg(fn ($a) => (float) $a->velue);
                $overallIndex = round(($rataRata / $scaleMax) * 100, 1);
                $predikat = $this->predikatFor($overallIndex);
            }

            $indikatorStats = $groups->map(function ($group) use ($answers, $scaleMax) {
                $jawabanIndikator = $answers->where('indikator_id', $group->indikator_id);
                $rata = $jawabanIndikator->isNotEmpty() ? $jawabanIndikator->avg(fn ($a) => (float) $a->velue) : 0;
                $index = round(($rata / $scaleMax) * 100, 1);

                return [
                    'indikator' => optional($group->indikator)->title ?? '-',
                    'rata' => round($rata, 2),
                    'index' => $index,
                    'color' => $this->predikatFor($index)['color'],
                ];
            });

            $terbaik = $indikatorStats->sortByDesc('index')->first();
            $perluPerhatian = $indikatorStats->sortBy('index')->first();

            $sentiment = $answers->groupBy('velue')->map->count()->sortKeys();

            $trend = collect(range(13, 0))->map(function ($i) use ($selected) {
                $date = today()->subDays($i);

                return [
                    'date' => $date->isoFormat('D MMM'),
                    'count' => SurveiPublic::where('survei_id', $selected->id)
                        ->whereDate('created_at', $date)
                        ->distinct('nip')
                        ->count('nip'),
                ];
            });

            $trendLabels = $trend->pluck('date');
            $trendData = $trend->pluck('count');
        }

        return view('admin.survei.kepuasan', [
            'title' => 'Dashboard Survei Kepuasan',
            'surveis' => $surveis,
            'selected' => $selected,
            'totalResponden' => $totalResponden,
            'overallIndex' => $overallIndex,
            'predikat' => $predikat,
            'indikatorStats' => $indikatorStats,
            'sentiment' => $sentiment,
            'scaleMax' => $scaleMax,
            'trendLabels' => $trendLabels,
            'trendData' => $trendData,
            'terbaik' => $terbaik,
            'perluPerhatian' => $perluPerhatian,
        ]);
    }

    /**
     * Klasifikasikan indeks kepuasan (skala 0-100) ke predikat kualitatif.
     *
     * @param  float  $index
     * @return array{label: string, color: string}
     */
    protected function predikatFor(float $index): array
    {
        if ($index >= 81) {
            return ['label' => 'Sangat Baik', 'color' => '#71dd37'];
        }

        if ($index >= 61) {
            return ['label' => 'Baik', 'color' => '#03c3ec'];
        }

        if ($index >= 41) {
            return ['label' => 'Cukup', 'color' => '#ffab00'];
        }

        return ['label' => 'Perlu Perbaikan', 'color' => '#ff3e1d'];
    }
}
