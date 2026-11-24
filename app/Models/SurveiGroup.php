<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveiGroup extends Model
{
    use \App\Models\Concerns\Auditable;
    use HasFactory;
    protected $guarded = ['id'];

    public function indikator() {
        return $this->belongsTo(SurveiIndikator::class);
    }

}
