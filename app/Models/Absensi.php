<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $guarded =['id'];
    protected $with = ['kegiatan'];

    public function kegiatan()
    {
        return $this ->belongsTo(Kegiatan::class);
    }

    // public function scopeFilter ($query, array $filters)
    // {

    //     $query->when($filters['search'] ?? false, function($query, $search){
    //         return $query->where('kegiatan_id','%' . $search . '%')
    //                      ->orWhere('nama','like','%' . $search . '%');
    //     });

    // }
}
