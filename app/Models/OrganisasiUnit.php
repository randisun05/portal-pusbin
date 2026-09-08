<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\Auditable;

class OrganisasiUnit extends Model
{
    use HasFactory;
    use Auditable;
    protected $guarded = ['id'];

    public function parent()
    {
        return $this->belongsTo(OrganisasiUnit::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(OrganisasiUnit::class, 'parent_id')->orderBy('urutan');
    }
}
