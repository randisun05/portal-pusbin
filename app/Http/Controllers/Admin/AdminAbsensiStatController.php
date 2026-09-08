<?php

namespace App\Http\Controllers\Admin;

use App\Models\Absensi;
use App\Http\Controllers\Controller;

class AdminAbsensiStatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total = Absensi::count();

        $perKegiatan = Absensi::selectRaw('kegiatan_id, count(*) as total')
            ->with('kegiatan:id,nama')
            ->groupBy('kegiatan_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $perInstansi = Absensi::selectRaw('instansi, count(*) as total')
            ->groupBy('instansi')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $trend = collect(range(13, 0))->map(function ($i) {
            $date = today()->subDays($i);
            return [
                'date' => $date->isoFormat('D MMM'),
                'count' => Absensi::whereDate('created_at', $date)->count(),
            ];
        });

        return view('admin.absensi.statistik', [
            'title' => 'Statistik Absensi',
            'total' => $total,
            'perKegiatan' => $perKegiatan,
            'perInstansi' => $perInstansi,
            'trendLabels' => $trend->pluck('date'),
            'trendData' => $trend->pluck('count'),
        ]);
    }
}
