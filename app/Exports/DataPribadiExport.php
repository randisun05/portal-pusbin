<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

/** Satu buku kerja, satu sheet per sumber data. $sheets: judul => [judul kolom, baris-baris]. */
class DataPribadiExport implements WithMultipleSheets
{
    public function __construct(private array $sheets)
    {
    }

    public function sheets(): array
    {
        $out = [];
        foreach ($this->sheets as $judul => [$kepala, $baris]) {
            $out[] = new class($judul, $kepala, $baris) implements FromArray, WithTitle {
                public function __construct(private string $judul, private array $kepala, private array $baris)
                {
                }

                public function array(): array
                {
                    // Sel diawali = + - @ dijadikan teks agar tidak dijalankan Excel sebagai rumus.
                    $aman = fn ($v) => is_string($v) && preg_match('/^[=+\-@]/', $v) ? "'" . $v : $v;

                    return array_merge([$this->kepala], array_map(fn ($r) => array_map($aman, $r), $this->baris));
                }

                public function title(): string
                {
                    return $this->judul;
                }
            };
        }

        return $out;
    }
}
