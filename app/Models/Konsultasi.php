<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Konsultasi extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = ['id'];

    public function getCreatedAttribut()
    {
       return Carbon::parse($this->attributes['jadwal'])
       ->translatedFormat('l, d F Y');
    }

    public static function tiket(){
        return $tiket = DB::table('konsultasis')->orderBy('id')->take(1)->get();
     }

     public function kode_konsultasi()
     {
         return $this->hasMany(KodeKonsultasi::class);
     }

}
