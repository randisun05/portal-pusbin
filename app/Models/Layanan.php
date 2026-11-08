<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Concerns\Auditable;

class Layanan extends Model
{
    use HasFactory;
    use Auditable;

    protected $guarded = ['id'];
}
