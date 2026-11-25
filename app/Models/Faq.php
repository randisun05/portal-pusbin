<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\Auditable;

class Faq extends Model
{
    use HasFactory;
    use Auditable;
    protected $guarded = ['id'];
}
