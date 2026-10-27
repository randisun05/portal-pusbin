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
        // Nilai token berasal dari input publik (form absensi/konsultasi tanpa
        // login), jadi WAJIB di-escape sebelum disisipkan - teks_keterangan
        // sendiri (milik admin) dibiarkan apa adanya karena dirender via {!! !!}
        // di view untuk mempertahankan format yang diketik admin.
        $tokens = [
            '{nama}' => e($absensi->nama),
            '{nip}' => e($absensi->nip),
            '{jabatan}' => e($absensi->jabatan),
            '{instansi}' => e($absensi->instansi),
            '{kegiatan}' => e(optional($absensi->kegiatan)->nama),
            '{waktu}' => e(optional($absensi->kegiatan)->waktu),
        ];

        return strtr($this->teks_keterangan, $tokens);
    }
}
