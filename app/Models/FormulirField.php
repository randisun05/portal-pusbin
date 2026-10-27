<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulirField extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'opsi' => 'array',
        'wajib' => 'boolean',
    ];

    public const TIPE_LIST = [
        'text' => 'Teks Pendek',
        'textarea' => 'Teks Panjang',
        'number' => 'Angka',
        'email' => 'Email',
        'select' => 'Pilihan (Dropdown)',
        'radio' => 'Pilihan (Radio)',
        'checkbox' => 'Pilihan Ganda (Checkbox)',
        'date' => 'Tanggal',
        'file' => 'Lampiran / Berkas',
        'rating' => 'Rating (1-5)',
    ];

    public const TIPE_BEROPSI = ['select', 'radio', 'checkbox'];

    public function formulir()
    {
        return $this->belongsTo(Formulir::class);
    }

    public function opsiList(): array
    {
        return $this->opsi ?? [];
    }
}
