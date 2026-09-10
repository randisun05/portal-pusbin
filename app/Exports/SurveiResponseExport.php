<?php

namespace App\Exports;

use App\Models\SurveiIndikator;
use App\Models\SurveiPublic;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SurveiResponseExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(protected int $surveiId)
    {
    }

    public function collection()
    {
        return SurveiPublic::where('survei_id', $this->surveiId)->latest()->get();
    }

    public function headings(): array
    {
        return ['NIP', 'Indikator', 'Jawaban', 'Tanggal Isi'];
    }

    public function map($row): array
    {
        return [
            $row->nip,
            optional(SurveiIndikator::find($row->indikator_id))->title,
            $row->velue,
            $row->created_at->format('d-m-Y H:i'),
        ];
    }
}
