<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\Auditable;

class Sertifikat extends Model
{
    use Auditable;
    protected $guarded = ['id'];
    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function absensi()
    {
        return $this->belongsTo(Absensi::class);
    }

    public static function generateNomor()
    {
        return 'SERT/' . date('Y') . '/' . str_pad(static::count() + 1, 5, '0', STR_PAD_LEFT);
    }
}
