<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DataPribadiExport;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\AuditLog;
use App\Models\Konsultasi;
use App\Models\Sertifikat;
use App\Models\SurveiPublic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Ekspor data pribadi per NIP (hak akses data subjek): semua jejak NIP itu di absensi, konsultasi,
 * jawaban survei, dan sertifikat. Hanya untuk peran dengan izin export-data-pribadi; setiap ekspor tercatat di audit log.
 */
class AdminDataPribadiController extends Controller
{
    public function index(Request $request)
    {
        $nip = (string) $request->query('nip', '');
        $ringkasan = null;

        if ($nip !== '') {
            $request->validate(['nip' => 'digits:18']);
            $ringkasan = $this->kumpulkan($nip)['ringkasan'];
        }

        return view('admin.data-pribadi.index', ['title' => 'Ekspor Data Pribadi', 'nip' => $nip, 'ringkasan' => $ringkasan]);
    }

    public function export(Request $request)
    {
        $data = $request->validate(['nip' => 'required|digits:18']);
        $nip = $data['nip'];
        $kumpul = $this->kumpulkan($nip);

        AuditLog::record('export', 'Ekspor data pribadi NIP ' . mask_nip($nip), 'DataPribadi', null, $kumpul['ringkasan']);

        return Excel::download(new DataPribadiExport($kumpul['sheets']), 'data-pribadi-' . $nip . '.xlsx');
    }

    /**
     * Anonimisasi (bukan hapus baris) agar statistik, nomor sertifikat, dan relasi tetap utuh: NIP, nama, email,
     * jabatan, instansi, dan saran diganti penanda anonim. Wajib mengetik kata ANONIMKAN; tercatat di audit log.
     */
    public function anonimkan(Request $request)
    {
        $data = $request->validate(['nip' => 'required|digits:18', 'konfirmasi' => 'required|in:ANONIMKAN']);
        $nip = $data['nip'];

        $jumlah = DB::transaction(function () use ($nip) {
            $n = ['absensi' => 0, 'konsultasi' => 0, 'jawaban_survei' => 0];
            foreach (Absensi::where('nip', $nip)->get() as $a) {
                $a->forceFill(['nip' => $this->penanda($a->id), 'nama' => 'Peserta Dianonimkan', 'email' => null, 'jabatan' => '-', 'instansi' => '-', 'saran' => null])->save();
                $n['absensi']++;
            }
            foreach (Konsultasi::where('nip', $nip)->get() as $k) {
                $k->forceFill(['nip' => $this->penanda($k->id), 'nama' => 'Peserta Dianonimkan', 'email' => 'anonim@invalid.local', 'instansi' => '-'])->save();
                $n['konsultasi']++;
            }
            foreach (SurveiPublic::where('nip', $nip)->get() as $sv) {
                $sv->forceFill(['nip' => $this->penanda($sv->id)])->save();
                $n['jawaban_survei']++;
            }

            return $n;
        });

        AuditLog::record('anonymize', 'Anonimisasi data pribadi NIP ' . mask_nip($nip), 'DataPribadi', null, $jumlah);

        return redirect('/admin/data-pribadi')->with('success', 'Data NIP ' . mask_nip($nip) . ' dianonimkan: ' . $jumlah['absensi'] . ' absensi, ' . $jumlah['konsultasi'] . ' konsultasi, ' . $jumlah['jawaban_survei'] . ' jawaban survei.');
    }

    private function penanda(int $id): string
    {
        return 'ANON' . str_pad((string) $id, 14, '0', STR_PAD_LEFT);
    }

    /** @return array{ringkasan: array<string,int>, sheets: array<string, array{0: array, 1: array}>} */
    private function kumpulkan(string $nip): array
    {
        $absensi = Absensi::with('kegiatan')->where('nip', $nip)->get();
        $konsultasi = Konsultasi::where('nip', $nip)->get();
        $survei = SurveiPublic::where('nip', $nip)->get();
        $sertifikat = Sertifikat::whereIn('absensi_id', $absensi->pluck('id'))->get();

        $sheets = [
            'Absensi' => [
                ['NIP', 'Nama', 'Email', 'Jabatan', 'Instansi', 'Kegiatan', 'Rating', 'Saran', 'Tanggal'],
                $absensi->map(fn ($a) => [$a->nip, $a->nama, $a->email, $a->jabatan, $a->instansi, optional($a->kegiatan)->nama, $a->rating, $a->saran, (string) $a->created_at])->all(),
            ],
            'Konsultasi' => [
                ['NIP', 'Nama', 'Email', 'Instansi', 'Tiket', 'Jadwal', 'Dijawab', 'Keterangan', 'Tanggal'],
                $konsultasi->map(fn ($k) => [$k->nip, $k->nama, $k->email, $k->instansi, $k->tiket, (string) $k->jadwal, $k->jawab ? 'Ya' : 'Belum', $k->keterangan, (string) $k->created_at])->all(),
            ],
            'Jawaban Survei' => [
                ['NIP', 'Survei ID', 'Indikator ID', 'Jawaban', 'Tanggal'],
                $survei->map(fn ($s) => [$s->nip, $s->survei_id, $s->indikator_id, $s->velue, (string) $s->created_at])->all(),
            ],
            'Sertifikat' => [
                ['Nomor Sertifikat', 'Status', 'Diterbitkan'],
                $sertifikat->map(fn ($s) => [$s->nomor_sertifikat, $s->status, (string) $s->created_at])->all(),
            ],
        ];

        return [
            'ringkasan' => ['absensi' => $absensi->count(), 'konsultasi' => $konsultasi->count(), 'jawaban_survei' => $survei->count(), 'sertifikat' => $sertifikat->count()],
            'sheets' => $sheets,
        ];
    }
}
