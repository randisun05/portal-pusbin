<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Konsultasi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function getCreatedAttribut()
    {
       return Carbon::parse($this->attributes['jadwal'])
       ->translatedFormat('l, d F Y');
    }

    public static function tiket(){
        return $tiket = DB::table('konsultasis')->orderBy('id')->take(1)->get();
     }

     /**
      * Buat nomor tiket unik: kode jenis konsultasi + 8 digit acak.
      * Ruang 10^8 per jenis menyulitkan penebakan nomor tiket orang lain.
      */
     public static function buatNomorTiket(string $kode): string
     {
         do {
             $tiket = $kode . str_pad((string) random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
         } while (static::where('tiket', $tiket)->exists());

         return $tiket;
     }

     public function kode_konsultasi()
     {
         return $this->belongsTo(KodeKonsultasi::class, 'kode_id');
     }

}
