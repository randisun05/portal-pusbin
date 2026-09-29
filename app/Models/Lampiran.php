<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Lampiran extends Model
{
    protected $guarded = ['id'];

    public function lampirable(): MorphTo
    {
        return $this->morphTo();
    }

    public function ukuranFormatted(): string
    {
        $bytes = (int) $this->ukuran;

        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1) . ' MB';
        }

        if ($bytes >= 1024) {
            return round($bytes / 1024, 1) . ' KB';
        }

        return $bytes . ' B';
    }
}
