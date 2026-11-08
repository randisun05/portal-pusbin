<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasLampiran;

class FormulirSubmission extends Model
{
    use HasFactory;
    use HasLampiran;

    protected $guarded = ['id'];

    protected $casts = [
        'data' => 'array',
    ];

    public function formulir()
    {
        return $this->belongsTo(Formulir::class);
    }

    public function jawabanUntuk(FormulirField $field)
    {
        return ($this->data ?? [])[$field->id] ?? null;
    }

    public function lampiranUntuk(FormulirField $field)
    {
        return $this->lampirans->firstWhere('keterangan', "field:{$field->id}");
    }
}
