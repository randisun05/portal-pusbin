<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasLampiran;

class Absensi extends Model
{
    use HasFactory;
    use HasLampiran;

    protected $guarded =['id'];
    protected $with = ['kegiatan'];

    public function kegiatan()
    {
        return $this ->belongsTo(Kegiatan::class);
    }

    public function sertifikat()
    {
        return $this->hasOne(Sertifikat::class);
    }

}
