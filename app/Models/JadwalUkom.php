<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class JadwalUkom extends Model
{
    use \App\Models\Concerns\Auditable;
    use HasFactory;
    protected $guarded =['id'];
}
