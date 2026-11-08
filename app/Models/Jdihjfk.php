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

    const STATUS_PUBLISHED = 'published';
    const STATUS_INTERNAL = 'internal';

    public function scopeFilter ($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('title','like','%' . $search . '%')
                         ->orWhere('deskripsi','like','%' . $search . '%');
        });
    }

    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }
}
