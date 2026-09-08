<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survei extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'type' => 'integer',
    ];

    public function indikators() {
        return $this->hasMany(SurveiGroup::class);
    }
}
