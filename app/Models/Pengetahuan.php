<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\Auditable;

class Pengetahuan extends Model
{
    use HasFactory;
    use Auditable;

    protected $guarded = ['id'];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }
}
