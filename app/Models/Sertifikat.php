<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\Auditable;

class Sertifikat extends Model
{
    use Auditable;
    protected $guarded = ['id'];
    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function absensi()
    {
        return $this->belongsTo(Absensi::class);
    }

    public function template()
    {
        return $this->belongsTo(SertifikatTemplate::class, 'template_id');
    }

    /**
     * Buat nomor sertifikat baru berdasarkan pengaturan penomoran aktif
     * (prefix, jumlah digit urut, dan apakah urutan direset tiap tahun).
     *
     * @return string
     */
    public static function generateNomor()
    {
        $pengaturan = PengaturanSertifikat::current();
        $tahun = date('Y');

        $query = static::query();
        if ($pengaturan->reset_tahunan) {
            $query->where('nomor_sertifikat', 'like', $pengaturan->prefix . '/' . $tahun . '/%');
        }

        $urutan = $query->count() + 1;

        return $pengaturan->prefix . '/' . $tahun . '/' . str_pad($urutan, $pengaturan->digit_urut, '0', STR_PAD_LEFT);
    }
}
