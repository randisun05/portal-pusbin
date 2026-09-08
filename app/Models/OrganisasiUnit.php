<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganisasiUnit extends Model
{
    use HasFactory;
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
