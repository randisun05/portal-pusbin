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

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermission(string $slug): bool
    {
        if ($this->name === self::SUPER_ADMIN) {
            return true;
        }

        return $this->permissions->contains('slug', $slug);
    }
}
