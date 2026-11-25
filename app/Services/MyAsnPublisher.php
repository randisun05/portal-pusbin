<?php

namespace App\Services;

use App\Http\Controllers\Concerns\GeneratesSertifikatQr;
use App\Models\Sertifikat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Publikasi sertifikat ke riwayat sertifikasi MyASN: POST /sertifikasi/save lalu POST /upload-dok-rw (PDF).
 * Bila save sudah berhasil tetapi upload gagal, percobaan berikutnya hanya mengulang upload (tidak membuat riwayat ganda).
 * Alur dan kontrak endpoint mengikuti project ujikom-pusbin.
 */
class MyAsnPublisher
{
    use GeneratesSertifikatQr;

    public function __construct(private SiasnApiService $siasn)
    {
    }

    public function available(): bool
    {
        return filled(config('services.myasn.url'));
    }

    public function publish(Sertifikat $sertifikat): Sertifikat
    {
        $sertifikat->loadMissing('absensi.kegiatan', 'template');
        $absensi = $sertifikat->absensi;

        try {
            if (! $sertifikat->myasn_riwayat_id) {
                $orangId = $this->siasn->orangId((string) $absensi->nip);
                if (! $orangId) {
                    return $this->gagal($sertifikat, "Id orang SIASN untuk NIP {$absensi->nip} tidak ditemukan.");
                }

                $saved = $this->parse($this->send(fn () => $this->request()->asJson()->post('/sertifikasi/save', $this->payload($sertifikat, $orangId))));
                $riwayat = $saved['mapData']['rwSertifikasiId'] ?? null;
                if (! $riwayat) {
                    throw new \RuntimeException('MyASN tidak mengembalikan id riwayat (mapData.rwSertifikasiId).');
                }
                $sertifikat->update(['myasn_riwayat_id' => $riwayat, 'myasn_orang_id' => $orangId]);
            }

            $pdf = Pdf::loadView('admin.sertifikat.pdf', [
                'sertifikat' => $sertifikat,
                'qrCode' => $this->qrCodeDataUri($sertifikat),
            ])->setPaper('a4', 'landscape')->output();

            $up = $this->parse($this->send(fn () => $this->request((int) config('services.myasn.upload_timeout'))
                ->attach('file', $pdf, 'sertifikat.pdf', ['Content-Type' => 'application/pdf'])
                ->post('/upload-dok-rw', [
                    'id_riwayat' => $sertifikat->myasn_riwayat_id,
                    'id_ref_dokumen' => (int) config('services.myasn.id_ref_dokumen'),
                ])));

            $sertifikat->update([
                'status' => 'terkirim',
                'sent_at' => now(),
                'sent_response' => 'MyASN: riwayat ' . $sertifikat->myasn_riwayat_id . ' dibuat dan dokumen diunggah. ' . mb_substr(json_encode($up), 0, 300),
            ]);
        } catch (\Throwable $e) {
            Log::warning('Publikasi MyASN sertifikat ' . $sertifikat->id . ' gagal: ' . $e->getMessage());
            $tahap = $sertifikat->myasn_riwayat_id ? 'Upload dokumen gagal (riwayat sudah dibuat, kirim ulang hanya mengulang upload): ' : 'Buat riwayat gagal: ';

            return $this->gagal($sertifikat, $tahap . $e->getMessage());
        }

        return $sertifikat;
    }

    /** @return array<string,mixed> */
    public function payload(Sertifikat $sertifikat, string $orangId): array
    {
        $cfg = config('services.myasn');
        $kegiatan = $sertifikat->absensi->kegiatan;
        $tanggal = ($sertifikat->created_at ?? now())->format('d-m-Y');

        return array_filter([
            'pnsOrangId' => $orangId,
            'nomorSertifikat' => $sertifikat->nomor_sertifikat,
            'namaSertifikasi' => mb_strtoupper((string) optional($kegiatan)->nama),
            'tanggalSertifikat' => $tanggal,
            'lembagaSertifikasiId' => $cfg['lembaga_id'],
            'lembagaSertifikasiNama' => $cfg['lembaga_nama'],
            'rumpunJabatanId' => $cfg['rumpun_jabatan_id'],
            // Slot dokumen: tanpa path, MyASN menolak upload ("id_riwayat dengan id_ref_dokumen tidak sesuai").
            'path' => [['dok_id' => (string) $cfg['id_ref_dokumen'], 'dok_nama' => 'Dok Sertifikat', 'dok_uri' => '', 'object' => '', 'slug' => (string) $cfg['id_ref_dokumen']]],
        ], fn ($v) => $v !== null && $v !== '');
    }

    private function gagal(Sertifikat $sertifikat, string $pesan): Sertifikat
    {
        $sertifikat->update(['status' => 'gagal_kirim', 'sent_response' => mb_substr($pesan, 0, 1000)]);

        return $sertifikat;
    }

    /** Gateway kadang menjawab 404 "No matching resource found" acak (belum diproses): aman diulang hingga 3 kali. */
    private function send(callable $call): Response
    {
        for ($try = 1; ; $try++) {
            $r = $call();
            if (! ($r->status() === 404 && str_contains($r->body(), 'No matching resource found')) || $try >= 3) {
                return $r;
            }
            usleep(500000 * $try);
        }
    }

    private function request(?int $timeout = null): PendingRequest
    {
        return Http::baseUrl(rtrim((string) config('services.myasn.url'), '/'))->acceptJson()
            ->timeout($timeout ?: (int) config('services.myasn.timeout'))
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->siasn->prodToken(),
                'Auth' => 'bearer ' . $this->siasn->authToken(),
            ]);
    }

    /** HTTP 2xx dan success != false dianggap berhasil. */
    private function parse(Response $r): array
    {
        $json = $r->json();
        $ok = $r->successful() && (! is_array($json) || (($json['success'] ?? $json['data']['success'] ?? true) !== false));
        if (! $ok) {
            throw new \RuntimeException('MyASN HTTP ' . $r->status() . ': ' . mb_substr($r->body(), 0, 300));
        }

        return is_array($json) ? $json : [];
    }
}
