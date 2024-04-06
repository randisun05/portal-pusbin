<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kegiatan extends Model
{
    use HasFactory;

    protected $guarded =['id'];

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

}
