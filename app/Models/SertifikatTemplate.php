<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\Auditable;

class SertifikatTemplate extends Model
{
    use Auditable;

    protected $guarded = ['id'];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function sertifikats()
    {
        return $this->hasMany(Sertifikat::class, 'template_id');
    }

    public static function default()
    {
        return static::where('is_default', true)->first() ?? static::first();
    }

    /**
     * Ganti tempat token {nama}/{nip}/dst pada teks keterangan dengan data
     * peserta yang sebenarnya untuk ditampilkan pada sertifikat.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return string
     */
    public function renderKeterangan($absensi): string
    {
        $tokens = [
            '{nama}' => $absensi->nama,
            '{nip}' => $absensi->nip,
            '{jabatan}' => $absensi->jabatan,
            '{instansi}' => $absensi->instansi,
            '{kegiatan}' => optional($absensi->kegiatan)->nama,
            '{waktu}' => optional($absensi->kegiatan)->waktu,
        ];

        return strtr($this->teks_keterangan, $tokens);
    }
}
