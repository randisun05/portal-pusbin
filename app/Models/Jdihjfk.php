<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\Auditable;

class Jdihjfk extends Model
{
    use HasFactory;
    use Auditable;
    protected $guarded = ['id'];

    public function scopeFilter ($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('title','like','%' . $search . '%')
                         ->orWhere('deskripsi','like','%' . $search . '%');
        });
}
}
