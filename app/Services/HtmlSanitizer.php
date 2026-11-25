<?php

namespace App\Services;

use HTMLPurifier;
use HTMLPurifier_Config;

class HtmlSanitizer
{
    /**
     * Bersihkan HTML dari konten editor rich-text (mis. Trix) sebelum
     * disimpan, supaya tag/atribut berbahaya (<script>, onerror=, javascript:)
     * tidak ikut tersimpan walau yang menulis adalah akun admin/editor
     * yang levelnya lebih rendah dari Super Admin.
     */
    public static function clean(?string $html): ?string
    {
        if ($html === null || $html === '') {
            return $html;
        }

        $cachePath = storage_path('app/htmlpurifier');
        if (! is_dir($cachePath)) {
            mkdir($cachePath, 0755, true);
        }

        $config = HTMLPurifier_Config::createDefault();
        $config->set('Cache.SerializerPath', $cachePath);
        $config->set('HTML.Allowed', 'p,br,strong,b,em,i,u,h1,h2,h3,h4,h5,h6,ul,ol,li,a[href|title|target],img[src|alt|width|height],blockquote,span,table,thead,tbody,tr,td,th,pre,code');
        $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true]);
        $config->set('HTML.TargetBlank', true);

        return (new HTMLPurifier($config))->purify($html);
    }
}
