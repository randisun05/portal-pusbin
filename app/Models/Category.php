<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \App\Models\Concerns\Auditable;
    use HasFactory;
    protected $guarded = ['id'];


    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

