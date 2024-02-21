<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survei extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function indikators() {
        return $this->hasMany(SurveiGroup::class);
    }
}
