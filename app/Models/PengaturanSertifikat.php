<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\Auditable;

class PengaturanSertifikat extends Model
{
    use Auditable;

    protected $guarded = ['id'];

    protected $casts = [
        'reset_tahunan' => 'boolean',
    ];

    public static function current()
    {
        return static::first() ?? static::create([
            'prefix' => 'SERT',
            'digit_urut' => 5,
            'reset_tahunan' => true,
        ]);
    }
}
