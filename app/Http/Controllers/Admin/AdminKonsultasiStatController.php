<?php

namespace App\Http\Controllers\Admin;

use App\Models\Konsultasi;
use App\Http\Controllers\Controller;

class AdminKonsultasiStatController extends Controller
{
    /**
     * Tampilkan rekap statistik konsultasi: jenis isu paling ramai,
     * instansi paling aktif, status jawaban, dan tren harian.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total = Konsultasi::count();
        $terjawab = Konsultasi::where('jawab', 1)->count();
        $belumTerjawab = $total - $terjawab;

        $perJenis = Konsultasi::selectRaw('kode_id, count(*) as total')
            ->with('kode_konsultasi:id,jenis')
            ->groupBy('kode_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $perInstansi = Konsultasi::selectRaw('instansi, count(*) as total')
            ->groupBy('instansi')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $trend = collect(range(13, 0))->map(function ($i) {
            $date = today()->subDays($i);
            return [
                'date' => $date->isoFormat('D MMM'),
                'count' => Konsultasi::whereDate('created_at', $date)->count(),
            ];
        });

        return view('admin.konsultasi.statistik', [
            'title' => 'Statistik Konsultasi',
            'total' => $total,
            'terjawab' => $terjawab,
            'belumTerjawab' => $belumTerjawab,
            'perJenis' => $perJenis,
            'perInstansi' => $perInstansi,
            'trendLabels' => $trend->pluck('date'),
            'trendData' => $trend->pluck('count'),
        ]);
    }
}
