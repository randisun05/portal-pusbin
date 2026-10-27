<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\Auditable;

class highlight extends Model
{
    use HasFactory;
    use Auditable;
    protected $guarded = ['id'];

    const GROUP_HERO = 'hero';
    const GROUP_ABOUT = 'about';
    const GROUP_FUNGSI = 'fungsi';

    public static function groups(): array
    {
        return [
            self::GROUP_HERO => 'Hero (Beranda Atas)',
            self::GROUP_ABOUT => 'Tentang Kami (Beranda)',
            self::GROUP_FUNGSI => 'Fungsi & Layanan Interaktif (Beranda)',
        ];
    }

    public function scopeGroup($query, string $group)
    {
        return $query->where('group', $group)->orderBy('urutan');
    }
}
