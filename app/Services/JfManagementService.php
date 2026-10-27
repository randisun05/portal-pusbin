<?php

namespace App\Services;

use App\Models\Sertifikat;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JfManagementService
{
    /**
     * Menyusun payload identitas & data kegiatan yang akan dikirim ke sistem
     * Manajemen Jabatan Fungsional (JF). Hanya data kegiatan dan identitas
     * peserta yang dikirim - tidak ada data sensitif lain.
     */
    public function buildPayload(Sertifikat $sertifikat): array
    {
        $absensi = $sertifikat->absensi()->with('kegiatan')->first();

        return [
            'nomor_sertifikat' => $sertifikat->nomor_sertifikat,
            'identitas' => [
                'nip' => $absensi->nip,
                'nama' => $absensi->nama,
                'jabatan' => $absensi->jabatan,
                'instansi' => $absensi->instansi,
            ],
            'kegiatan' => [
                'nama' => optional($absensi->kegiatan)->nama,
                'jenis' => optional($absensi->kegiatan)->jenis,
                'waktu' => optional($absensi->kegiatan)->waktu,
            ],
            'diterbitkan_pada' => $sertifikat->created_at->toIso8601String(),
        ];
    }

    /**
     * Kirim data sertifikat ke sistem Manajemen JF eksternal.
     * Karena endpoint resmi belum tersedia, method ini disiapkan agar tinggal
     * diisi JF_MANAGEMENT_API_URL di .env saat integrasi sudah siap - sampai
     * saat itu, payload tetap disusun & dicatat tanpa mengklaim terkirim.
     */
    public function send(Sertifikat $sertifikat): Sertifikat
    {
        $payload = $this->buildPayload($sertifikat);
        $url = config('services.jf_management.url');

        if (empty($url)) {
            $sertifikat->update([
                'status' => 'gagal_kirim',
                'sent_response' => 'Endpoint Manajemen JF belum dikonfigurasi (JF_MANAGEMENT_API_URL kosong). Payload telah disiapkan: ' . json_encode($payload),
            ]);

            Log::info('JfManagementService: endpoint belum dikonfigurasi, payload disiapkan.', $payload);

            return $sertifikat;
        }

        try {
            $response = Http::withToken((string) config('services.jf_management.key'))
                ->timeout(15)
                ->post($url, $payload);

            $sertifikat->update([
                'status' => $response->successful() ? 'terkirim' : 'gagal_kirim',
                'sent_at' => now(),
                'sent_response' => 'HTTP ' . $response->status() . ': ' . $response->body(),
            ]);
        } catch (\Throwable $e) {
            $sertifikat->update([
                'status' => 'gagal_kirim',
                'sent_response' => 'Gagal menghubungi endpoint: ' . $e->getMessage(),
            ]);
        }

        return $sertifikat;
    }
}
