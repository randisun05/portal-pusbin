<?php

namespace App\Http\Controllers\Admin;

use App\Models\Survei;
use App\Models\SurveiGroup;
use App\Models\SurveiPublic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminSurveiStatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $surveis = Survei::all()
            ->map(function ($survei) {
                $survei->jumlah_responden = SurveiPublic::where('survei_id', $survei->id)->distinct('nip')->count('nip');
                return $survei;
            });

        $selected = null;
        $indikatorStats = collect();

        if ($request->survei) {
            $selected = Survei::find($request->survei);

            if ($selected) {
                $groups = SurveiGroup::with('indikator')->where('survei_id', $selected->id)->get();

                $indikatorStats = $groups->map(function ($group) use ($selected) {
                    $answers = SurveiPublic::where('survei_id', $selected->id)
                        ->where('indikator_id', $group->indikator_id)
                        ->get();

                    if ($selected->type === 1) {
                        return [
                            'indikator' => optional($group->indikator)->title,
                            'type' => 'text',
                            'answers' => $answers->pluck('velue'),
                        ];
                    }

                    $counts = $answers->groupBy('velue')->map->count();

                    return [
                        'indikator' => optional($group->indikator)->title,
                        'type' => 'chart',
                        'labels' => $counts->keys(),
                        'values' => $counts->values(),
                    ];
                });
            }
        }

        return view('admin.survei.statistik', [
            'title' => 'Statistik Survei',
            'surveis' => $surveis,
            'selected' => $selected,
            'indikatorStats' => $indikatorStats,
        ]);
    }
}
