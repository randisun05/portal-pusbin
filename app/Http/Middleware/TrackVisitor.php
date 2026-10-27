<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PageView;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response)  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('get') && ! $request->is('admin*') && ! $request->ajax()) {
            try {
                PageView::create([
                    'path' => '/' . ltrim($request->path(), '/'),
                    'ip_address' => $request->ip(),
                    'session_id' => $request->session()->getId(),
                    'referrer' => $request->header('referer'),
                    'user_agent' => substr((string) $request->userAgent(), 0, 255),
                ]);
            } catch (\Throwable $e) {
                // Jangan sampai pencatatan pengunjung mengganggu request utama
            }
        }

        return $next($request);
    }
}
