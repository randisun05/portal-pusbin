<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    protected $guarded = ['id'];

    const TYPES = ['suka', 'setuju', 'menarik'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
