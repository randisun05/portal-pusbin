<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasLampiran;

class PesanKontak extends Model
{
    use HasFactory;
    use HasLampiran;
    protected $guarded = ['id'];
}
