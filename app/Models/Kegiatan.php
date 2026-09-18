<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function materis()
    {
        return $this->hasMany(MateriPaparan::class)->orderBy('urutan');
    }

    public function isPresensiTertutup(): bool
    {
        if (! $this->batas_presensi) {
            return false;
        }

        return Carbon::parse($this->batas_presensi)->isPast();
    }

}
