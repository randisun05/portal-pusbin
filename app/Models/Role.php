<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\Auditable;

class Role extends Model
{
    use HasFactory;
    use Auditable;
    protected $guarded = ['id'];

    const SUPER_ADMIN = 'super-admin';
    const ADMIN = 'admin';
    const EDITOR = 'editor';

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
