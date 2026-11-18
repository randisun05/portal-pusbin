<?php

namespace Database\Seeders;

use Database\Seeders\Support\DummyImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Melengkapi tabel yang masih kosong / minim data supaya portal siap dipakai.
 *
 * Aman dijalankan berulang dan tidak menghapus apa pun: setiap bagian hanya
 * menambah data bila tabel/barisnya belum ada.
 *
 *   php artisan db:seed --class=LengkapiDataSeeder
 */
class LengkapiDataSeeder extends Seeder
{
    private string $disk;

    public function run()
    {
        $this->disk = storage_path('app/public');
        mt_srand(20261118);

        $this->pengguna();
        $this->dashboard();
        $this->formulir();
        $this->pesanKontak();
        $this->komentarDanReaksi();
        $this->absensiKegiatanLalu();
        $this->ratingAbsensi();
        $this->sertifikat();
        $this->surveiPublik();

        $this->command?->info('Data lengkap selesai ditambahkan (tanpa menghapus data lama).');
    }

    // ------------------------------------------------------------------ util

    private function nip(): string
    {
        return '19' . mt_rand(70, 99) . sprintf('%02d%02d', mt_rand(1, 12), mt_rand(1, 28)) . '20' . mt_rand(0, 24) . mt_rand(1, 2) . sprintf('%03d', mt_rand(1, 999));
    }

    private function faker(): \Faker\Generator
    {
        return \Faker\Factory::create('id_ID');
    }

    private function tulisPdf(string $path, string $judul): void
    {
        @mkdir(dirname($path), 0775, true);
        $teks = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], Str::ascii($judul));
        $stream = "BT /F1 16 Tf 60 760 Td ($teks) Tj ET";
        $objs = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>',
            '<< /Length ' . strlen($stream) . " >>\nstream\n$stream\nendstream",
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
        ];
        $pdf = "%PDF-1.4\n";
        $offsets = [];
        foreach ($objs as $i => $o) {
            $offsets[] = strlen($pdf);
            $pdf .= ($i + 1) . " 0 obj\n$o\nendobj\n";
        }
        $xref = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objs) + 1) . "\n0000000000 65535 f \n";
        foreach ($offsets as $off) {
            $pdf .= sprintf("%010d 00000 n \n", $off);
        }
        $pdf .= "trailer\n<< /Size " . (count($objs) + 1) . " /Root 1 0 R >>\nstartxref\n$xref\n%%EOF";
        file_put_contents($path, $pdf);
    }

    // -------------------------------------------------------------- pengguna

    private function pengguna(): void
    {
        $roles = DB::table('roles')->pluck('id', 'name');
        $akun = [
            ['Admin Operasional', 'admin.operasional', 'operasional@gmail.com', 'admin'],
            ['Editor Konten', 'editor.konten', 'editor@gmail.com', 'editor'],
        ];

        foreach ($akun as [$nama, $username, $email, $role]) {
            if (! isset($roles[$role]) || DB::table('users')->where('email', $email)->exists()) {
                continue;
            }
            DB::table('users')->insert([
                'role_id' => $roles[$role], 'name' => $nama, 'username' => $username,
                'email' => $email, 'password' => bcrypt('password'),
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }
    }

    // ------------------------------------------------------------- dashboard

    private function dashboard(): void
    {
        if (DB::table('dashboards')->exists()) {
            return;
        }

        $rows = [
            ['Dashboard JFK', 'Data sebaran dan kebutuhan Jabatan Fungsional Kepegawaian secara nasional.', 'https://dashboard.skom.id/', 'Dashboard'],
            ['Rekapitulasi Uji Kompetensi', 'Rekap peserta, kelulusan, dan jadwal uji kompetensi per periode.', '/jadwal-ukom', 'Uji Kompetensi'],
            ['Statistik Layanan Konsultasi', 'Ringkasan tiket konsultasi dan topik yang paling sering ditanyakan.', '/konsultasi', 'Konsultasi'],
        ];

        foreach ($rows as [$nama, $deskripsi, $link, $tag]) {
            $rel = 'dashboard-image/' . Str::slug($nama) . '.jpg';
            DummyImage::card("{$this->disk}/$rel", $nama, $tag);
            DB::table('dashboards')->insert([
                'nama' => $nama, 'deskripsi' => $deskripsi, 'link' => $link, 'image' => $rel,
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }
    }

    // -------------------------------------------------------------- formulir

    private function formulir(): void
    {
        if (DB::table('formulirs')->exists()) {
            return;
        }

        $f = $this->faker();
        $instansi = ['Kementerian Keuangan', 'Kementerian Kesehatan', 'Pemerintah Provinsi Jawa Barat', 'Pemerintah Kota Surabaya',
            'Kementerian Agama', 'Pemerintah Kabupaten Sleman', 'Pemerintah Provinsi Sumatera Utara', 'Kantor Regional BKN'];

        $definisi = [
            [
                'judul' => 'Pengumpulan Data Pejabat Fungsional Kepegawaian',
                'deskripsi' => 'Pemutakhiran data pejabat fungsional kepegawaian di instansi Anda.',
                'fields' => [
                    ['Nama Lengkap', 'text', null, 1],
                    ['NIP', 'text', null, 1],
                    ['Email Dinas', 'email', null, 1],
                    ['Instansi', 'text', null, 1],
                    ['Jenjang Jabatan', 'select', ['Ahli Pertama', 'Ahli Muda', 'Ahli Madya', 'Ahli Utama'], 1],
                    ['Tanggal Pengangkatan', 'date', null, 0],
                    ['Jumlah Angka Kredit', 'number', null, 0],
                    ['SK Pengangkatan', 'file', null, 1],
                ],
            ],
            [
                'judul' => 'Pengumpulan Dokumen Usul Angka Kredit',
                'deskripsi' => 'Unggah berkas usul penetapan angka kredit (PAK) untuk diverifikasi tim penilai.',
                'fields' => [
                    ['Nama Lengkap', 'text', null, 1],
                    ['NIP', 'text', null, 1],
                    ['Periode Penilaian', 'radio', ['Semester I', 'Semester II', 'Tahunan'], 1],
                    ['Jenis Usul', 'checkbox', ['Kenaikan Pangkat', 'Kenaikan Jenjang', 'Pengangkatan Pertama', 'Perpindahan Jabatan'], 1],
                    ['Catatan untuk Penilai', 'textarea', null, 0],
                    ['Berkas Usul (PDF)', 'file', null, 1],
                    ['Dokumen Pendukung', 'file', null, 0],
                ],
            ],
            [
                'judul' => 'Pendaftaran Peserta Bimtek',
                'deskripsi' => 'Pendaftaran peserta bimbingan teknis jabatan fungsional kepegawaian.',
                'fields' => [
                    ['Nama Lengkap', 'text', null, 1],
                    ['NIP', 'text', null, 1],
                    ['Email', 'email', null, 1],
                    ['Instansi', 'text', null, 1],
                    ['Materi yang Diminati', 'checkbox', ['Penyusunan SKP', 'Penetapan Angka Kredit', 'Uji Kompetensi', 'Dashboard JFK'], 1],
                    ['Kebutuhan Khusus', 'textarea', null, 0],
                ],
            ],
            [
                'judul' => 'Evaluasi Layanan Direktorat JF MASN',
                'deskripsi' => 'Bantu kami meningkatkan layanan dengan mengisi evaluasi singkat berikut.',
                'fields' => [
                    ['Layanan yang Digunakan', 'select', ['Uji Kompetensi', 'Konsultasi Online', 'Penetapan Angka Kredit', 'Repository & Informasi'], 1],
                    ['Kecepatan Respons', 'rating', null, 1],
                    ['Kualitas Layanan', 'rating', null, 1],
                    ['Kemudahan Penggunaan Portal', 'rating', null, 1],
                    ['Saran dan Masukan', 'textarea', null, 0],
                ],
            ],
        ];

        foreach ($definisi as $i => $def) {
            $fid = DB::table('formulirs')->insertGetId([
                'judul' => $def['judul'], 'slug' => Str::slug($def['judul']), 'deskripsi' => $def['deskripsi'],
                'status' => '1', 'created_at' => now()->subDays(20 - $i), 'updated_at' => now(),
            ]);

            $fields = [];
            foreach ($def['fields'] as $urut => [$label, $tipe, $opsi, $wajib]) {
                $fields[] = [
                    'id' => DB::table('formulir_fields')->insertGetId([
                        'formulir_id' => $fid, 'label' => $label, 'tipe' => $tipe,
                        'opsi' => $opsi ? json_encode($opsi) : null, 'wajib' => $wajib, 'urutan' => $urut,
                        'created_at' => now(), 'updated_at' => now(),
                    ]),
                    'label' => $label, 'tipe' => $tipe, 'opsi' => $opsi,
                ];
            }

            $n = mt_rand(6, 12);
            for ($s = 0; $s < $n; $s++) {
                $waktu = now()->subDays(mt_rand(0, 15))->subMinutes(mt_rand(0, 1000));
                $nama = $f->name();
                $data = [];
                $berkas = [];

                foreach ($fields as $fl) {
                    $key = $fl['id'];
                    $label = Str::lower($fl['label']);
                    switch ($fl['tipe']) {
                        case 'text':
                            $data[$key] = str_contains($label, 'nama') ? $nama
                                : (str_contains($label, 'nip') ? $this->nip() : $instansi[array_rand($instansi)]);
                            break;
                        case 'email':
                            $data[$key] = Str::slug($nama, '.') . '@' . (mt_rand(0, 1) ? 'kemenkeu.go.id' : 'bkn.go.id');
                            break;
                        case 'number':
                            $data[$key] = (string) mt_rand(50, 450);
                            break;
                        case 'date':
                            $data[$key] = now()->subDays(mt_rand(60, 1500))->format('Y-m-d');
                            break;
                        case 'select':
                        case 'radio':
                            $data[$key] = $fl['opsi'][array_rand($fl['opsi'])];
                            break;
                        case 'checkbox':
                            $pilih = (array) array_rand(array_flip($fl['opsi']), mt_rand(1, 2));
                            $data[$key] = array_values($pilih);
                            break;
                        case 'rating':
                            $data[$key] = (string) mt_rand(3, 5);
                            break;
                        case 'textarea':
                            if (mt_rand(0, 2) > 0) {
                                $data[$key] = $f->randomElement([
                                    'Layanan sudah baik, mohon jadwal dibuat lebih awal.',
                                    'Mohon materi dibagikan sebelum kegiatan berlangsung.',
                                    'Proses verifikasi sebaiknya diberi notifikasi otomatis.',
                                    'Tidak ada, terima kasih.',
                                ]);
                            }
                            break;
                        case 'file':
                            // Field berkas opsional hanya diisi sebagian peserta.
                            $wajib = DB::table('formulir_fields')->where('id', $key)->value('wajib');
                            if ($wajib || mt_rand(0, 1)) {
                                $berkas[] = $fl;
                            }
                            break;
                    }
                }

                $sid = DB::table('formulir_submissions')->insertGetId([
                    'formulir_id' => $fid, 'data' => json_encode($data),
                    'created_at' => $waktu, 'updated_at' => $waktu,
                ]);

                foreach ($berkas as $fl) {
                    $nama_file = Str::slug($fl['label']) . "-$sid.pdf";
                    $rel = "formulir/$nama_file";
                    $this->tulisPdf("{$this->disk}/$rel", "{$fl['label']} - $nama (contoh)");
                    DB::table('lampirans')->insert([
                        'lampirable_type' => 'App\\Models\\FormulirSubmission', 'lampirable_id' => $sid,
                        'keterangan' => "field:{$fl['id']}", 'path' => $rel, 'nama_asli' => $nama_file,
                        'mime' => 'application/pdf', 'ukuran' => filesize("{$this->disk}/$rel"),
                        'created_at' => $waktu, 'updated_at' => $waktu,
                    ]);
                }
            }
        }
    }

    // ---------------------------------------------------------- pesan kontak

    private function pesanKontak(): void
    {
        if (DB::table('pesan_kontaks')->exists()) {
            return;
        }

        $f = $this->faker();
        $pesan = [
            ['Jadwal Uji Kompetensi', 'Mohon informasi jadwal dan syarat pendaftaran uji kompetensi periode berikutnya.'],
            ['Akses Dashboard JFK', 'Kami belum memiliki akun untuk mengakses Dashboard JFK. Bagaimana cara mengajukannya?'],
            ['Verifikasi Sertifikat', 'Nomor sertifikat kami tidak ditemukan saat diverifikasi. Mohon dibantu pengecekan.'],
            ['Permohonan Narasumber', 'Instansi kami mengundang narasumber untuk sosialisasi JF Kepegawaian bulan depan.'],
            ['Perubahan Data Pejabat', 'Mohon panduan untuk memperbarui data pejabat fungsional di instansi kami.'],
            ['Saran Perbaikan Portal', 'Mohon ditambahkan notifikasi email ketika jadwal konsultasi sudah ditetapkan.'],
            ['Penetapan Angka Kredit', 'Berapa lama proses penetapan angka kredit setelah berkas usul dikirim?'],
        ];

        foreach ($pesan as $i => [$subjek, $isi]) {
            $nama = $f->name();
            $waktu = now()->subDays(mt_rand(0, 14))->subMinutes(mt_rand(0, 900));
            DB::table('pesan_kontaks')->insert([
                'nama' => $nama, 'email' => Str::slug($nama, '.') . '@' . ($i % 2 ? 'gmail.com' : 'bkn.go.id'),
                'telepon' => '08' . mt_rand(11, 99) . mt_rand(10000000, 99999999),
                'subjek' => $subjek, 'pesan' => $isi, 'dibaca' => $i < 3 ? 1 : 0,
                'created_at' => $waktu, 'updated_at' => $waktu,
            ]);
        }
    }

    // ----------------------------------------------------- komentar & reaksi

    private function komentarDanReaksi(): void
    {
        $postIds = DB::table('posts')->orderByDesc('id')->limit(8)->pluck('id');
        if ($postIds->isEmpty()) {
            return;
        }

        if (DB::table('comments')->count() < 5) {
            $f = $this->faker();
            $isi = [
                'Informasinya sangat membantu, terima kasih.',
                'Apakah ada panduan teknis lanjutannya?',
                'Mohon info jadwal kegiatan berikutnya.',
                'Sudah kami teruskan ke seluruh pejabat fungsional di instansi kami.',
                'Semoga layanan ini terus ditingkatkan.',
            ];
            foreach ($isi as $i => $body) {
                $nama = $f->name();
                DB::table('comments')->insert([
                    'post_id' => $postIds[$i % $postIds->count()], 'nama' => $nama,
                    'email' => Str::slug($nama, '.') . '@gmail.com', 'body' => $body,
                    'approved' => $i < 4 ? 1 : 0,
                    'created_at' => now()->subDays(mt_rand(0, 10)), 'updated_at' => now(),
                ]);
            }
        }

        if (! DB::table('reactions')->exists()) {
            $types = ['suka', 'setuju', 'menarik'];
            foreach ($postIds as $pid) {
                for ($i = 0, $n = mt_rand(2, 8); $i < $n; $i++) {
                    DB::table('reactions')->insert([
                        'post_id' => $pid, 'session_id' => Str::random(40), 'type' => $types[array_rand($types)],
                        'created_at' => now()->subDays(mt_rand(0, 10)), 'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    // ------------------------------------------- absensi kegiatan yang lewat

    /** Kegiatan yang sudah lewat tapi belum punya peserta (jadwal bergeser seiring waktu). */
    private function absensiKegiatanLalu(): void
    {
        $f = $this->faker();
        $instansi = ['Kementerian Keuangan', 'Kementerian Kesehatan', 'Pemerintah Provinsi Jawa Barat', 'Pemerintah Kota Surabaya',
            'Kementerian Agama', 'Pemerintah Kabupaten Sleman', 'Kantor Regional BKN', 'Pemerintah Kota Makassar'];
        $jabatan = ['Analis SDM Aparatur Ahli Pertama', 'Analis SDM Aparatur Ahli Muda', 'Analis SDM Aparatur Ahli Madya', 'Pengelola Kepegawaian', 'Operator Kepegawaian'];

        $kegiatans = DB::table('kegiatans')->where('status', '1')->where('waktu', '<', now()->format('Y-m-d H:i:s'))->get();
        foreach ($kegiatans as $k) {
            if (DB::table('absensis')->where('kegiatan_id', $k->id)->exists()) {
                continue;
            }

            $waktu = \Illuminate\Support\Carbon::parse($k->waktu);
            for ($i = 0, $n = mt_rand(10, 22); $i < $n; $i++) {
                DB::table('absensis')->insert([
                    'kegiatan_id' => $k->id, 'nip' => $this->nip(), 'nama' => $f->name(), 'email' => $f->unique()->safeEmail(),
                    'jabatan' => $jabatan[array_rand($jabatan)], 'instansi' => $instansi[array_rand($instansi)],
                    'status' => '1', 'created_at' => $waktu->copy()->addMinutes(mt_rand(0, 60)), 'updated_at' => $waktu,
                ]);
            }

            if (empty($k->batas_presensi)) {
                DB::table('kegiatans')->where('id', $k->id)->update(['batas_presensi' => $waktu->copy()->addHours(6)->format('Y-m-d H:i:s')]);
            }
        }
    }

    /** Rating & saran peserta untuk kegiatan yang sudah lewat. */
    private function ratingAbsensi(): void
    {
        $saran = [
            'Materi jelas dan mudah dipahami.',
            'Narasumber responsif menjawab pertanyaan.',
            'Mohon durasi sesi tanya jawab ditambah.',
            'Materi dibagikan lebih awal akan sangat membantu.',
            'Kegiatan berjalan tertib dan tepat waktu.',
            'Koneksi daring sempat terputus, mohon diperbaiki.',
        ];

        $rows = DB::table('absensis')->whereNull('rating')->get(['id']);
        foreach ($rows as $r) {
            if (mt_rand(1, 100) > 65) {
                continue; // tidak semua peserta mengisi rating
            }
            DB::table('absensis')->where('id', $r->id)->update([
                'rating' => mt_rand(3, 5),
                'saran' => mt_rand(0, 2) ? $saran[array_rand($saran)] : null,
            ]);
        }
    }

    // ------------------------------------------------------------ sertifikat

    private function sertifikat(): void
    {
        $template = DB::table('sertifikat_templates')->value('id');
        if (! $template || DB::table('sertifikats')->count() >= 10) {
            return;
        }

        $tahun = now()->year;
        $urut = 0;
        foreach (DB::table('sertifikats')->where('nomor_sertifikat', 'like', "%/$tahun/%")->pluck('nomor_sertifikat') as $nomor) {
            $urut = max($urut, (int) substr($nomor, strrpos($nomor, '/') + 1));
        }

        $absensi = DB::table('absensis')
            ->join('kegiatans', 'kegiatans.id', '=', 'absensis.kegiatan_id')
            ->whereNotIn('absensis.id', DB::table('sertifikats')->pluck('absensi_id'))
            ->whereIn('kegiatans.jenis', ['Bimtek', 'Workshop', 'Sosialisasi'])
            ->where('absensis.status', '1')
            ->orderBy('absensis.id')
            ->limit(12)
            ->get(['absensis.id']);

        foreach ($absensi as $a) {
            DB::table('sertifikats')->insert([
                'absensi_id' => $a->id, 'template_id' => $template,
                'nomor_sertifikat' => sprintf('JFMASN/%d/%04d', $tahun, ++$urut),
                'status' => 'diterbitkan', 'created_at' => now()->subDays(mt_rand(0, 6)), 'updated_at' => now(),
            ]);
        }
    }

    // ---------------------------------------------------------- survei publik

    private function surveiPublik(): void
    {
        if (DB::table('survei_publics')->count() > 11) {
            return;
        }

        $f = $this->faker();
        $groups = DB::table('survei_groups')->get()->groupBy('survei_id');
        $indikator = DB::table('survei_indikators')->pluck('title', 'id');
        $teks = ['Nama', 'No HP', 'Link'];

        foreach ($groups as $surveiId => $items) {
            for ($i = 0, $n = mt_rand(6, 12); $i < $n; $i++) {
                $nip = $this->nip();
                $waktu = now()->subDays(mt_rand(0, 20))->subMinutes(mt_rand(0, 900));
                foreach ($items as $g) {
                    $judul = $indikator[$g->indikator_id] ?? '';
                    $nilai = match ($judul) {
                        'Nama' => $f->name(),
                        'No HP' => '08' . mt_rand(11, 99) . mt_rand(10000000, 99999999),
                        'Link' => 'https://drive.example.go.id/' . Str::random(8),
                        default => (string) mt_rand(2, 4),
                    };
                    DB::table('survei_publics')->insert([
                        'nip' => $nip, 'survei_id' => (string) $surveiId, 'indikator_id' => (string) $g->indikator_id,
                        'velue' => $nilai, 'created_at' => $waktu, 'updated_at' => $waktu,
                    ]);
                }
            }
        }
    }
}
