<?php

namespace Database\Seeders\Support;

/**
 * Generator gambar dummy bertema BKN (biru navy + emas) memakai GD, jadi tidak
 * ada aset pihak ketiga / berhak cipta. Hasilnya JPEG yang deterministik
 * (pola dibuat dari hash judul) sehingga seed ulang menghasilkan gambar sama.
 */
class DummyImage
{
    // Palet mengacu warna identitas BKN: biru tua, biru, emas.
    const NAVY = [8, 38, 82];
    const BLUE = [14, 82, 160];
    const SKY = [64, 140, 210];
    const GOLD = [242, 183, 5];
    const WHITE = [255, 255, 255];

    private static function font(bool $bold = true): ?string
    {
        $candidates = $bold
            ? ['C:/Windows/Fonts/segoeuib.ttf', 'C:/Windows/Fonts/arialbd.ttf', '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf', '/usr/share/fonts/dejavu/DejaVuSans-Bold.ttf']
            : ['C:/Windows/Fonts/segoeui.ttf', 'C:/Windows/Fonts/arial.ttf', '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf', '/usr/share/fonts/dejavu/DejaVuSans.ttf'];

        foreach ($candidates as $path) {
            if (is_file($path)) {
                return $path;
            }
        }

        return null;
    }

    private static function color($im, array $rgb, int $alpha = 0)
    {
        return imagecolorallocatealpha($im, $rgb[0], $rgb[1], $rgb[2], $alpha);
    }

    private static function gradient($im, int $w, int $h, array $from, array $to): void
    {
        // Gradien diagonal: dihitung per baris dengan geser horizontal kecil
        // supaya cepat (tanpa per-pixel) tapi tetap terlihat diagonal.
        for ($y = 0; $y < $h; $y++) {
            $t = $y / max(1, $h - 1);
            $c = imagecolorallocate(
                $im,
                (int) ($from[0] + ($to[0] - $from[0]) * $t),
                (int) ($from[1] + ($to[1] - $from[1]) * $t),
                (int) ($from[2] + ($to[2] - $from[2]) * $t)
            );
            imageline($im, 0, $y, $w, $y, $c);
        }
    }

    /** Pola geometris halus: lingkaran konsentris + garis diagonal. */
    private static function pattern($im, int $w, int $h, string $seed): void
    {
        mt_srand(crc32($seed));
        for ($i = 0; $i < 5; $i++) {
            $cx = mt_rand((int) ($w * 0.4), $w);
            $cy = mt_rand(-(int) ($h * 0.2), (int) ($h * 0.8));
            $r0 = mt_rand((int) ($h * 0.25), (int) ($h * 0.6));
            for ($k = 0; $k < 4; $k++) {
                imagesetthickness($im, 2);
                imageellipse($im, $cx, $cy, ($r0 + $k * 46) * 2, ($r0 + $k * 46) * 2, self::color($im, self::WHITE, 118));
            }
        }
        imagesetthickness($im, 1);
        $step = max(34, (int) ($w / 28));
        for ($x = -$h; $x < $w; $x += $step) {
            imageline($im, $x, $h, $x + $h, 0, self::color($im, self::WHITE, 122));
        }
        // Titik emas aksen
        for ($i = 0; $i < 14; $i++) {
            $r = mt_rand(4, 11);
            imagefilledellipse($im, mt_rand(0, $w), mt_rand(0, $h), $r, $r, self::color($im, self::GOLD, 70));
        }
        mt_srand();
    }

    private static function wrap(string $text, string $font, float $size, int $maxWidth): array
    {
        $lines = [];
        $line = '';
        foreach (preg_split('/\s+/', trim($text)) as $word) {
            $try = $line === '' ? $word : $line . ' ' . $word;
            $box = imagettfbbox($size, 0, $font, $try);
            if (($box[2] - $box[0]) > $maxWidth && $line !== '') {
                $lines[] = $line;
                $line = $word;
            } else {
                $line = $try;
            }
        }
        if ($line !== '') {
            $lines[] = $line;
        }

        return $lines;
    }

    private static function text($im, string $text, int $x, int $y, float $size, array $rgb, int $maxWidth, bool $bold = true, int $maxLines = 4): int
    {
        $font = self::font($bold);
        $col = self::color($im, $rgb);
        if (!$font) {
            imagestring($im, 5, $x, $y, $text, $col);

            return $y + 20;
        }
        $lines = array_slice(self::wrap($text, $font, $size, $maxWidth), 0, $maxLines);
        foreach ($lines as $line) {
            $y += (int) ($size * 1.45);
            imagettftext($im, $size, 0, $x, $y, $col, $font, $line);
        }

        return $y;
    }

    private static function badge($im, int $w, int $h, string $label, int $x, int $y, float $size): void
    {
        $font = self::font(true);
        if (!$font) {
            return;
        }
        $box = imagettfbbox($size, 0, $font, $label);
        $tw = $box[2] - $box[0];
        $pad = (int) ($size * 0.8);
        imagefilledrectangle($im, $x, $y, $x + $tw + $pad * 2, $y + (int) ($size * 2.4), self::color($im, self::GOLD));
        imagettftext($im, $size, 0, $x + $pad, $y + (int) ($size * 1.7), self::color($im, self::NAVY), $font, $label);
    }

    private static function save($im, string $path, int $quality = 86): string
    {
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        imagejpeg($im, $path, $quality);
        imagedestroy($im);

        return $path;
    }

    /** Latar lebar tanpa teks (hero, about, breadcrumb). */
    public static function backdrop(string $path, int $w, int $h, string $seed, bool $light = false): string
    {
        $im = imagecreatetruecolor($w, $h);
        self::gradient($im, $w, $h, $light ? self::BLUE : self::NAVY, $light ? self::SKY : self::BLUE);
        self::pattern($im, $w, $h, $seed);
        // Pita emas tipis di bawah
        imagefilledrectangle($im, 0, $h - 10, $w, $h, self::color($im, self::GOLD));

        return self::save($im, $path, 82);
    }

    /** Gambar sampul berita / kegiatan / layanan dengan judul. */
    public static function card(string $path, string $title, string $tag = '', int $w = 1200, int $h = 675): string
    {
        $variants = [
            [self::NAVY, self::BLUE],
            [self::BLUE, self::SKY],
            [[10, 60, 110], [24, 110, 150]],
            [[20, 30, 90], [14, 82, 160]],
        ];
        $v = $variants[crc32($title) % count($variants)];

        $im = imagecreatetruecolor($w, $h);
        self::gradient($im, $w, $h, $v[0], $v[1]);
        self::pattern($im, $w, $h, $title);

        // Panel gelap transparan di kiri bawah agar teks terbaca
        imagefilledrectangle($im, 0, (int) ($h * 0.42), $w, $h, self::color($im, self::NAVY, 72));
        imagefilledrectangle($im, 0, (int) ($h * 0.42), 14, $h, self::color($im, self::GOLD));

        if ($tag !== '') {
            self::badge($im, $w, $h, strtoupper($tag), 56, (int) ($h * 0.47), $h / 34);
        }
        $y = self::text($im, $title, 56, (int) ($h * 0.55), $h / 14, self::WHITE, $w - 112, true, 3);
        self::text($im, 'DIREKTORAT JABATAN FUNGSIONAL MASN  •  BKN', 56, $h - (int) ($h * 0.11), $h / 40, self::GOLD, $w - 112, true, 1);

        return self::save($im, $path);
    }

    /** Foto profil placeholder: inisial di atas gradien biru. */
    public static function avatar(string $path, string $name, int $size = 480): string
    {
        $words = preg_split('/\s+/', preg_replace('/[^\p{L}\s]/u', '', $name));
        $words = array_values(array_filter($words, fn ($x) => mb_strlen($x) > 1 && !in_array(strtolower($x), ['dr', 'ir', 'drs', 'hj', 'h'])));
        $initials = strtoupper(mb_substr($words[0] ?? 'X', 0, 1) . mb_substr($words[1] ?? '', 0, 1));

        $im = imagecreatetruecolor($size, $size);
        self::gradient($im, $size, $size, self::BLUE, self::NAVY);
        self::pattern($im, $size, $size, $name);
        $font = self::font(true);
        if ($font) {
            $fs = $size / 3.2;
            $box = imagettfbbox($fs, 0, $font, $initials);
            $tw = $box[2] - $box[0];
            imagettftext($im, $fs, 0, (int) (($size - $tw) / 2), (int) ($size * 0.6), self::color($im, self::WHITE), $font, $initials);
        }
        imagefilledrectangle($im, 0, $size - 12, $size, $size, self::color($im, self::GOLD));

        return self::save($im, $path, 88);
    }

    /** Sampul dokumen untuk Repository JF MASN. */
    public static function cover(string $path, string $title, string $kind, int $w = 600, int $h = 800): string
    {
        $im = imagecreatetruecolor($w, $h);
        self::gradient($im, $w, $h, self::NAVY, self::BLUE);
        self::pattern($im, $w, $h, $title);
        imagefilledrectangle($im, 36, 36, $w - 36, 40, self::color($im, self::GOLD));
        self::text($im, 'BADAN KEPEGAWAIAN NEGARA', 48, 56, $w / 26, self::GOLD, $w - 96, true, 2);
        self::badge($im, $w, $h, strtoupper($kind), 48, (int) ($h * 0.30), $w / 28);
        self::text($im, $title, 48, (int) ($h * 0.38), $w / 15, self::WHITE, $w - 96, true, 7);

        return self::save($im, $path);
    }
}
