<?php

namespace App\Exports;

use App\Models\Absensi;
use App\Models\Kegiatan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AbsensiExport implements FromCollection, WithHeadings, WithMapping
{
    protected int $nomor = 0;

    public function __construct(protected ?string $kegiatanId = null)
    {
    }

    public function collection()
    {
        $absensis = Absensi::with('kegiatan')->latest();
        $ids = Kegiatan::where('jenis', 'Konsultasi')->pluck('id');
        $absensis->whereNotIn('kegiatan_id', $ids);

        if ($this->kegiatanId) {
            $absensis->where('kegiatan_id', $this->kegiatanId);
        }

        return $absensis->get();
    }

    public function headings(): array
    {
        return ['No', 'NIP', 'Nama', 'Jabatan', 'Instansi', 'Email', 'Kegiatan', 'Waktu Kegiatan', 'Tanggal Absen'];
    }

    public function map($absensi): array
    {
        $this->nomor++;

        return [
            $this->nomor,
            $absensi->nip,
            $absensi->nama,
            $absensi->jabatan,
            $absensi->instansi,
            $absensi->email,
            optional($absensi->kegiatan)->nama,
            optional($absensi->kegiatan)->waktu,
            $absensi->created_at->format('d-m-Y H:i'),
        ];
    }
}
