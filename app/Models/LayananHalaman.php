<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\Auditable;

class LayananHalaman extends Model
{
    use Auditable;

    protected $table = 'layanan_halamans';

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('urutan')->orderBy('id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getUrlAttribute()
    {
        return '/layanan/' . $this->slug;
    }
}
