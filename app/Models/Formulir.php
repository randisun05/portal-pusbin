<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\Auditable;

class Formulir extends Model
{
    use HasFactory;
    use Auditable;

    protected $guarded = ['id'];

    public function fields()
    {
        return $this->hasMany(FormulirField::class)->orderBy('urutan');
    }

    public function submissions()
    {
        return $this->hasMany(FormulirSubmission::class);
    }
}
