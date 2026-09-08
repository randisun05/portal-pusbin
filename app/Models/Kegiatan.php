<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Concerns\Auditable;

class Kegiatan extends Model
{
    use HasFactory;
    use Auditable;

    protected $guarded =['id'];

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

}
