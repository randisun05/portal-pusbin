<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    /**
     * Tambahkan header keamanan standar ke semua response web.
     *
     * Catatan soal CSP: script-src & style-src terpaksa pakai 'unsafe-inline'
     * karena banyak view di aplikasi ini punya <script>/<style> inline
     * (form JS, chart, dsb) - menghilangkannya butuh refactor besar (nonce
     * atau pindahkan semua ke file .js/.css terpisah). Jadi CSP ini BUKAN
     * pengganti sanitasi/escape output (itu yang benar-benar mencegah XSS
     * dieksekusi) - ini lapisan tambahan yang membatasi asal resource yang
     * boleh dimuat (script/style/font/frame dari domain tak dikenal ditolak
     * browser), membatasi base-uri & form-action, dan blokir plugin/object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response)  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
        $response->headers->set('Content-Security-Policy', $this->contentSecurityPolicy($request));

        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }

    protected function contentSecurityPolicy(Request $request): string
    {
        // Bundle webpack tema admin (jquery, helpers, popper, menu, apexcharts, dst) memakai eval().
        // Tanpa 'unsafe-eval' semua JS admin mati (menu, dropdown, grafik). Dibatasi hanya untuk
        // area /admin (ber-login); halaman publik tetap tanpa eval. Solusi jangka panjang: ganti
        // file vendor admin dengan build produksi tanpa eval, lalu hapus pengecualian ini.
        $scriptSrc = "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://www.google.com https://www.gstatic.com";
        if ($request->is('admin', 'admin/*')) {
            $scriptSrc = str_replace("'unsafe-inline'", "'unsafe-inline' 'unsafe-eval'", $scriptSrc);
        }

        $directives = [
            "default-src 'self'",
            $scriptSrc,
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com",
            "font-src 'self' data: https://fonts.gstatic.com https://cdnjs.cloudflare.com",
            "img-src 'self' data:",
            "frame-src https://www.google.com https://www.gstatic.com",
            "connect-src 'self' https://www.google.com https://www.gstatic.com",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'self'",
        ];

        return implode('; ', $directives);
    }
}
