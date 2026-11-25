<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Data lama (seed/import awal) menyimpan path gambar yang tidak pernah
     * benar-benar ada di storage (path Windows dengan backslash, nilai
     * placeholder literal "image", dsb). Migration ini membersihkan nilai
     * tersebut supaya tampilan jatuh ke ikon placeholder, bukan gambar
     * rusak - dijalankan sebagai migration (bukan tinker manual) supaya
     * ikut membersihkan data yang sama saat di-deploy ke server produksi.
     *
     * @return void
     */
    public function up()
    {
        $targets = [
            ['table' => 'layanans', 'column' => 'image', 'empty' => null],
            ['table' => 'kegiatans', 'column' => 'image', 'empty' => ''],
            ['table' => 'jdihjfks', 'column' => 'image', 'empty' => null],
        ];

        foreach ($targets as $target) {
            if (! Schema::hasTable($target['table']) || ! Schema::hasColumn($target['table'], $target['column'])) {
                continue;
            }

            $rows = DB::table($target['table'])
                ->whereNotNull($target['column'])
                ->where($target['column'], '!=', '')
                ->get(['id', $target['column']]);

            foreach ($rows as $row) {
                $path = $row->{$target['column']};

                if (! Storage::disk('public')->exists($path)) {
                    DB::table($target['table'])
                        ->where('id', $row->id)
                        ->update([$target['column'] => $target['empty']]);
                }
            }
        }
    }

    /**
     * Pembersihan data tidak bisa (dan tidak perlu) dikembalikan.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
