<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\Auditable;

class Survei extends Model
{
    use HasFactory;
    use Auditable;
    protected $guarded = ['id'];
    protected $casts = [
        'type' => 'integer',
    ];

    public function indikators() {
        return $this->hasMany(SurveiGroup::class);
    }
}
