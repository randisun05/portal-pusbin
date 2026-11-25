<?php

namespace App\Exports;

use App\Models\Formulir;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FormulirSubmissionExport implements FromCollection, WithHeadings, WithMapping
{
    protected $fields;

    public function __construct(protected Formulir $formulir)
    {
        $this->fields = $formulir->fields;
    }

    public function collection()
    {
        return $this->formulir->submissions()->with('lampirans')->latest()->get();
    }

    public function headings(): array
    {
        return array_merge(
            $this->fields->pluck('label')->all(),
            ['Tanggal Isi']
        );
    }

    public function map($submission): array
    {
        $baris = $this->fields->map(function ($field) use ($submission) {
            if ($field->tipe === 'file') {
                $lampiran = $submission->lampirans->firstWhere('keterangan', "field:{$field->id}");
                return $lampiran ? asset('storage/' . $lampiran->path) : '';
            }

            $jawaban = $submission->jawabanUntuk($field);

            return is_array($jawaban) ? implode(', ', $jawaban) : (string) $jawaban;
        })->all();

        $baris[] = $submission->created_at->format('d-m-Y H:i');

        return $baris;
    }
}
