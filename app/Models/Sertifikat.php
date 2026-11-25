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

        // Urutan berlanjut lintas prefix (mengganti prefix tidak mengulang dari 1) dan memakai
        // nomor terbesar + 1, bukan jumlah baris, agar tidak bentrok setelah ada sertifikat yang dihapus.
        $query = static::query();
        if ($pengaturan->reset_tahunan) {
            $query->where('nomor_sertifikat', 'like', '%/' . $tahun . '/%');
        }

        $terakhir = 0;
        foreach ($query->pluck('nomor_sertifikat') as $nomor) {
            $bagian = substr(strrchr('/' . $nomor, '/'), 1);
            if (ctype_digit($bagian)) {
                $terakhir = max($terakhir, (int) $bagian);
            }
        }
        $urutan = $terakhir + 1;

        return $pengaturan->prefix . '/' . $tahun . '/' . str_pad($urutan, $pengaturan->digit_urut, '0', STR_PAD_LEFT);
    }
}
