<?php

namespace App\Http\Controllers\Admin;

use App\Models\PageView;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class AdminPengunjungController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalViews = PageView::count();
        $todayViews = PageView::whereDate('created_at', today())->count();
        $todayUnique = PageView::whereDate('created_at', today())->distinct('session_id')->count('session_id');
        $weekUnique = PageView::where('created_at', '>=', now()->subDays(7))->distinct('session_id')->count('session_id');

        $days = collect(range(13, 0))->map(function ($i) {
            $date = today()->subDays($i);
            return [
                'date' => $date->isoFormat('D MMM'),
                'count' => PageView::whereDate('created_at', $date)->count(),
            ];
        });

        $topPages = PageView::selectRaw('path, count(*) as total')
            ->groupBy('path')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $topReferrers = PageView::selectRaw('referrer, count(*) as total')
            ->whereNotNull('referrer')
            ->where('referrer', 'not like', '%' . request()->getHost() . '%')
            ->groupBy('referrer')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return view('admin.pengunjung.index', [
            'title' => 'Monitoring Pengunjung',
            'totalViews' => $totalViews,
            'todayViews' => $todayViews,
            'todayUnique' => $todayUnique,
            'weekUnique' => $weekUnique,
            'chartLabels' => $days->pluck('date'),
            'chartData' => $days->pluck('count'),
            'topPages' => $topPages,
            'topReferrers' => $topReferrers,
        ]);
    }
}
