<?php

namespace Database\Seeders;

use Database\Seeders\Support\DummyImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Data contoh lengkap untuk Portal Direktorat JF MASN (BKN).
 *
 * Jalankan: php artisan db:seed --class=DummyDataSeeder
 *
 * - Aman dijalankan berulang: tabel KONTEN dikosongkan lalu diisi ulang.
 *   User, role, permission, kategori, survei, kode konsultasi, jadwal ujikom,
 *   dan halaman layanan TIDAK disentuh.
 * - Regulasi yang disebut (UU 20/2023, PermenPAN-RB 1/2023, Peraturan BKN 3/2023,
 *   Perpres 92/2024) nyata; seluruh nama pegawai, peserta, tanggal kegiatan,
 *   angka, dan isi berita adalah FIKTIF untuk keperluan pengembangan.
 * - Gambar dibuat lokal lewat GD (tanpa aset pihak ketiga) di storage/app/public.
 */
class DummyDataSeeder extends Seeder
{
    private string $disk;

    public function run()
    {
        $this->disk = storage_path('app/public');
        mt_srand(2026);

        $this->bersihkan();
        $this->gambarTema();
        $this->profil();
        $this->highlight();
        $this->layanan();
        $this->organisasi();
        $this->berita();
        $this->kegiatan();
        $this->faq();
        $this->repository();
        $this->pengetahuan();
        $this->sertifikat();
        $this->konsultasi();

        $this->command?->info('Data dummy selesai. Login admin: admin@gmail.com / password');
    }

    private function bersihkan(): void
    {
        Schema::disableForeignKeyConstraints();
        foreach (['posts', 'kegiatans', 'materi_paparans', 'absensis', 'faqs', 'pengetahuans', 'highlights', 'layanans',
                  'misi_items', 'organisasi_units', 'profils', 'jdihjfks', 'konsultasis', 'sertifikat_templates',
                  'pengaturan_sertifikats'] as $t) {
            if (Schema::hasTable($t)) {
                DB::table($t)->delete();
            }
        }
        Schema::enableForeignKeyConstraints();
    }

    // ------------------------------------------------------------------ gambar

    private function gambarTema(): void
    {
        // Menggantikan gambar bawaan template Flexor dengan latar bertema BKN.
        $img = public_path('assets-flexor/img');
        DummyImage::backdrop("$img/hero-bg.jpg", 1920, 1080, 'hero');
        DummyImage::backdrop("$img/about.jpg", 1200, 900, 'about', true);
        DummyImage::backdrop("$img/services.jpg", 1200, 900, 'services', true);
        foreach ([1, 2, 3, 4] as $i) {
            DummyImage::backdrop("$img/services-$i.jpg", 1000, 700, "services-$i", $i % 2 === 0);
        }
        DummyImage::backdrop("$img/testimonials-bg.jpg", 1920, 800, 'testimonials');
    }

    private function simpan(string $dir, string $nama, callable $buat): string
    {
        $rel = "$dir/$nama.jpg";
        $buat("{$this->disk}/$rel");

        return $rel;
    }

    // ------------------------------------------------------------------ profil

    private function profil(): void
    {
        DB::table('profils')->insert([
            'hero_judul' => 'Pembinaan Jabatan Fungsional Kepegawaian yang Profesional dan Transparan',
            'hero_deskripsi' => 'Portal resmi Direktorat Jabatan Fungsional Manajemen ASN, Badan Kepegawaian Negara — layanan uji kompetensi, penetapan angka kredit, konsultasi, dan informasi jabatan fungsional dalam satu pintu.',
            'about_judul' => 'Mengawal Profesionalisme Pejabat Fungsional Kepegawaian di Seluruh Indonesia',
            'tentang' => "Direktorat Jabatan Fungsional Manajemen Aparatur Sipil Negara (Direktorat JF MASN) adalah unit kerja di lingkungan Badan Kepegawaian Negara (BKN) yang melaksanakan pembinaan jabatan fungsional di bidang kepegawaian: perumusan kebutuhan formasi, penyelenggaraan uji kompetensi, penilaian dan penetapan angka kredit, serta pengembangan kompetensi pejabat fungsional.\n\nBerlandaskan UU Nomor 20 Tahun 2023 tentang Aparatur Sipil Negara, Peraturan Menteri PAN-RB Nomor 1 Tahun 2023 tentang Jabatan Fungsional, dan Peraturan BKN Nomor 3 Tahun 2023 tentang Angka Kredit, Kenaikan Pangkat, dan Jenjang Jabatan Fungsional, kami berkomitmen memberikan layanan yang cepat, akuntabel, dan mudah diakses secara daring.",
            'visi' => 'Terwujudnya pembinaan jabatan fungsional manajemen ASN yang profesional, akuntabel, dan berbasis teknologi dalam mendukung meritokrasi dan profesionalitas ASN menuju Indonesia Emas 2045.',
            'alamat' => 'Gedung II Kantor Pusat BKN, Jl. Mayjen Sutoyo No. 12, Cililitan, Jakarta Timur 13640',
            'telepon' => '(021) 8093008',
            'email' => 'jfmasn@bkn.example.go.id',
            'jam_operasional' => 'Senin – Jumat, 08.00 – 16.00 WIB (istirahat 12.00 – 13.00)',
            'facebook' => 'https://facebook.com/',
            'instagram' => 'https://instagram.com/',
            'twitter' => 'https://x.com/',
            'youtube' => 'https://youtube.com/',
            'maps_embed' => null,
            'stat_label_organisasi' => 'Unit & Pejabat',
            'stat_label_layanan' => 'Layanan Aktif',
            'stat_label_kegiatan' => 'Kegiatan',
            'stat_label_publikasi' => 'Publikasi',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        $misi = [
            'Menyusun kebutuhan dan formasi jabatan fungsional kepegawaian secara akurat, terukur, dan berkelanjutan.',
            'Menyelenggarakan uji kompetensi jabatan fungsional yang objektif, transparan, dan dapat diakses secara daring.',
            'Melaksanakan penilaian dan penetapan angka kredit secara tepat waktu berbasis kinerja (SKP).',
            'Mengembangkan kompetensi pejabat fungsional melalui bimbingan teknis, workshop, dan pelatihan.',
            'Memberikan layanan konsultasi dan informasi jabatan fungsional yang responsif dan terdokumentasi.',
            'Mengelola data dan sistem informasi jabatan fungsional yang terintegrasi dan aman.',
        ];
        foreach ($misi as $i => $isi) {
            DB::table('misi_items')->insert(['isi' => $isi, 'urutan' => $i, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    private function highlight(): void
    {
        $now = now();
        $rows = [
            ['hero', 'Uji Kompetensi Daring', 'Dilaksanakan 4 periode setahun melalui CBT, tanpa dipungut biaya.', 'bi-clipboard-data', null],
            ['hero', 'Konsultasi Terdokumentasi', 'Ajukan pertanyaan, dapatkan nomor tiket, dan pantau jawabannya.', 'bi-headset', null],
            ['hero', 'Sertifikat Digital', 'Unduh sertifikat kegiatan langsung dengan QR verifikasi keaslian.', 'bi-patch-check', null],
            ['about', 'Empat Periode Setiap Tahun', 'Jadwal ujikom terbuka pada Februari, April, Juli, dan Oktober.', 'bi-calendar-check', null],
            ['about', 'Sepenuhnya Daring', 'Dari pendaftaran, ujian, hingga hasil dapat diikuti tanpa hadir fisik.', 'bi-laptop', null],
            ['about', 'Tanpa Biaya', 'Seluruh layanan Direktorat JF MASN diberikan tanpa pungutan.', 'bi-cash-coin', null],
            ['fungsi', 'Survei Kepuasan', 'Nilai layanan kami dan ikuti survei yang sedang berjalan.', 'bi-clipboard2-pulse', '/survei'],
            ['fungsi', 'Konsultasi Online', 'Tanyakan seputar jabatan fungsional dan pantau lewat nomor tiket.', 'bi-headset', '/konsultasi'],
            ['fungsi', 'Repository JF MASN', 'Cari peraturan, surat edaran, dan dokumen rujukan JF.', 'bi-journal-text', '/repository'],
            ['fungsi', 'Verifikasi Sertifikat', 'Periksa keaslian sertifikat dengan nomor atau kode QR.', 'bi-patch-check', '/verifikasi-sertifikat'],
        ];
        foreach ($rows as $i => [$grup, $nama, $desc, $icon, $link]) {
            DB::table('highlights')->insert([
                'group' => $grup, 'name' => $nama, 'desc' => $desc, 'icon' => $icon, 'link' => $link,
                'image' => null, 'urutan' => $i % 4, 'created_at' => $now, 'updated_at' => $now,
            ]);
        }
    }

    private function layanan(): void
    {
        $rows = [
            ['Pendaftaran Uji Kompetensi', 'Daftar uji kompetensi kenaikan jenjang & perpindahan JF periode berjalan.', 'https://ujikom.bkn.go.id', 'bi-pencil-square'],
            ['CBT Ujikom', 'Akses ujian berbasis komputer secara daring dengan pengawasan.', 'https://ujikom.bkn.go.id', 'bi-pc-display'],
            ['Konsultasi Online', 'Tanya jawab seputar JF Kepegawaian dengan nomor tiket.', '/konsultasi', 'bi-headset'],
            ['Dashboard JFK', 'Data statistik pejabat fungsional kepegawaian nasional.', 'https://dashboard.skom.id/', 'bi-bar-chart-line'],
            ['Repository JF MASN', 'Kumpulan peraturan & dokumen terkait JF MASN.', '/repository', 'bi-journal-text'],
            ['Presensi Kegiatan', 'Isi daftar hadir kegiatan dan unduh sertifikat.', '/absensi', 'bi-person-check'],
            ['Survei Layanan', 'Sampaikan penilaian dan saran atas layanan kami.', '/survei', 'bi-emoji-smile'],
            ['Verifikasi Sertifikat', 'Cek keaslian sertifikat kegiatan.', '/verifikasi-sertifikat', 'bi-patch-check'],
        ];
        foreach ($rows as [$nama, $desc, $link, $icon]) {
            DB::table('layanans')->insert([
                'nama' => $nama, 'deskripsi' => $desc, 'link' => $link, 'icon' => $icon,
                'image' => $this->simpan('post-image', 'layanan-' . Str::slug($nama), fn ($p) => DummyImage::card($p, $nama, 'Layanan', 800, 450)),
                'status' => '1', 'created_at' => now(), 'updated_at' => now(),
            ]);
        }
    }

    // -------------------------------------------------------------- organisasi

    private function organisasi(): void
    {
        $buat = function (string $nama, string $jabatan, string $unit, ?int $parent, int $urut, ?string $desc = null) {
            $slug = Str::slug($nama);

            return DB::table('organisasi_units')->insertGetId([
                'nama' => $nama, 'jabatan' => $jabatan, 'unit' => $unit, 'parent_id' => $parent, 'urutan' => $urut,
                'deskripsi' => $desc,
                'email' => Str::slug(Str::words($nama, 2, ''), '.') . '@bkn.example.go.id',
                'telepon' => null,
                'foto' => $this->simpan('organisasi-image', $slug, fn ($p) => DummyImage::avatar($p, $nama)),
                'created_at' => now(), 'updated_at' => now(),
            ]);
        };

        $dir = $buat('Dr. Bagus Prasetyo Wicaksono, M.Si.', 'Direktur Jabatan Fungsional MASN', 'Pimpinan', null, 0,
            'Memimpin pembinaan jabatan fungsional manajemen ASN secara nasional.');

        $pokja = [
            ['Pokja 1 – Formasi & Kebutuhan JF', 'Maharani Kusumawardhani, S.E., M.M.', 'Koordinator Analis SDM Aparatur Ahli Madya',
                [['Dimas Aryo Nugroho, S.Kom.', 'Analis SDM Aparatur Ahli Muda'], ['Citra Lestari Anggraini, S.Sos.', 'Analis SDM Aparatur Ahli Pertama']]],
            ['Pokja 2 – Uji Kompetensi', 'Hendra Setiawan, S.H., M.H.', 'Koordinator Analis SDM Aparatur Ahli Madya',
                [['Fitria Nurhayati, S.Psi.', 'Analis SDM Aparatur Ahli Muda'], ['Rizky Fauzan Hakim, S.T.', 'Pranata Komputer Ahli Muda'], ['Wulandari Puspitasari, S.Pd.', 'Analis SDM Aparatur Ahli Pertama']]],
            ['Pokja 3 – Angka Kredit & Pengangkatan', 'Yoga Pratama Siregar, S.IP., M.Si.', 'Koordinator Analis SDM Aparatur Ahli Madya',
                [['Nadia Safitri Rahmawati, S.AP.', 'Analis SDM Aparatur Ahli Muda'], ['Bayu Kurniawan, S.E.', 'Analis SDM Aparatur Ahli Pertama'], ['Intan Permatasari, S.H.', 'Analis SDM Aparatur Ahli Pertama']]],
            ['Pokja 4 – Pengembangan Kompetensi & Sistem Informasi', 'Dr. Laila Mardiyah, S.Kom., M.M.S.I.', 'Koordinator Analis SDM Aparatur Ahli Madya',
                [['Arief Budiman, S.Kom.', 'Pranata Komputer Ahli Muda'], ['Sekar Ayu Pratiwi, S.Sos.', 'Analis SDM Aparatur Ahli Pertama']]],
        ];

        foreach ($pokja as $i => [$unit, $nama, $jabatan, $staf]) {
            $kid = $buat($nama, $jabatan, $unit, $dir, $i + 1);
            foreach ($staf as $j => [$n, $jb]) {
                $buat($n, $jb, $unit, $kid, $j);
            }
        }
        $tu = $buat('Ratna Dewi Anggarini, S.E.', 'Pengelola Urusan Tata Usaha', 'Tata Usaha', $dir, 5);
        $buat('Joko Santoso', 'Pengadministrasi Perkantoran', 'Tata Usaha', $tu, 0);
    }

    // ------------------------------------------------------------------ berita

    private function berita(): void
    {
        $cat = DB::table('categories')->pluck('id', 'slug');
        $uid = DB::table('users')->value('id') ?? 1;

        $p = fn (string ...$para) => implode('', array_map(fn ($x) => "<p>$x</p>", $para));

        $posts = [
            ['pengumuman', 'Jadwal dan Tata Cara Pendaftaran Uji Kompetensi JF Kepegawaian Periode IV Tahun 2026',
                'Pendaftaran uji kompetensi periode IV dibuka melalui sistem daring, dengan batas akhir akhir Agustus 2026.',
                $p('Direktorat Jabatan Fungsional Manajemen ASN mengumumkan pembukaan pendaftaran uji kompetensi (ujikom) jabatan fungsional kepegawaian periode IV Tahun 2026 yang akan dilaksanakan pada bulan Oktober 2026.',
                   'Pendaftaran dilakukan secara daring oleh operator kepegawaian instansi masing-masing. Peserta harus telah memenuhi persyaratan jenjang, memiliki penilaian kinerja minimal baik pada periode terakhir, dan melampirkan dokumen pendukung sesuai ketentuan.',
                   '<strong>Tahapan singkat:</strong> (1) registrasi akun operator, (2) pengusulan peserta, (3) verifikasi berkas oleh tim, (4) penerbitan kartu peserta, (5) pelaksanaan ujian berbasis komputer (CBT), (6) pengumuman hasil.',
                   'Seluruh tahapan tidak dipungut biaya. Peserta diimbau mewaspadai pihak yang mengatasnamakan BKN dan meminta pembayaran.')],
            ['regulasi', 'Mengenal Peraturan BKN Nomor 3 Tahun 2023: Angka Kredit Berbasis Kinerja',
                'Penghitungan angka kredit kini bertumpu pada capaian kinerja melalui Sasaran Kinerja Pegawai (SKP).',
                $p('Peraturan BKN Nomor 3 Tahun 2023 mengatur angka kredit, kenaikan pangkat, dan jenjang jabatan fungsional, sebagai pelaksanaan Peraturan Menteri PAN-RB Nomor 1 Tahun 2023 tentang Jabatan Fungsional.',
                   'Salah satu perubahan pokoknya adalah pergeseran dari penilaian berbasis butir kegiatan menuju penilaian berbasis kinerja melalui Sasaran Kinerja Pegawai (SKP). Pejabat fungsional tidak lagi mengumpulkan bukti per butir kegiatan, melainkan fokus pada capaian kinerja tahunan.',
                   'Angka kredit menjadi nilai kuantitatif hasil kerja, sedangkan koefisien angka kredit adalah target minimal yang harus dipenuhi setiap tahun pada tiap jenjang jabatan.',
                   'Naskah lengkap dan buku panduan teknis dapat dirujuk melalui menu Repository JF MASN.')],
            ['kegiatan', 'Bimtek Penyusunan SKP dan Penetapan Angka Kredit Diikuti Ratusan Operator Kepegawaian',
                'Bimbingan teknis daring membahas alur pengusulan PAK serta kesalahan umum yang sering terjadi.',
                $p('Direktorat JF MASN menyelenggarakan bimbingan teknis penyusunan SKP dan penetapan angka kredit bagi operator kepegawaian dan pejabat fungsional dari berbagai instansi pusat dan daerah.',
                   'Materi mencakup alur pengusulan penetapan angka kredit (PAK), kelengkapan dokumen, serta simulasi penghitungan. Peserta juga mendapat ruang tanya jawab langsung dengan tim penilai.',
                   'Materi paparan dan sertifikat kegiatan dapat diunduh melalui menu Kegiatan setelah peserta mengisi presensi dan survei kepuasan.')],
            ['pengumuman', 'Layanan Konsultasi Online Kini Dilengkapi Nomor Tiket dan Pelacakan Jawaban',
                'Pemohon dapat memantau status konsultasi tanpa harus menanyakan ulang melalui kanal lain.',
                $p('Untuk meningkatkan transparansi, setiap pertanyaan yang masuk melalui layanan Konsultasi Online kini memperoleh nomor tiket unik.',
                   'Dengan nomor tersebut, pemohon dapat membuka halaman pelacakan untuk melihat jadwal konsultasi, petugas penanggung jawab (PIC), serta jawaban yang telah diberikan.',
                   'Layanan tersedia setiap hari kerja pukul 08.00–16.00 WIB.')],
            ['regulasi', 'Peraturan Menteri PAN-RB Nomor 1 Tahun 2023 tentang Jabatan Fungsional: Poin Penting bagi Pejabat Fungsional',
                'Ringkasan ketentuan jenjang, pengangkatan, dan pembinaan jabatan fungsional.',
                $p('Permen PAN-RB Nomor 1 Tahun 2023 menjadi rujukan utama pengelolaan jabatan fungsional ASN, mencakup jenjang jabatan, pengangkatan, perpindahan, kenaikan jenjang, serta pemberhentian.',
                   'Ketentuan teknis terkait angka kredit dan kenaikan pangkat kemudian dijabarkan oleh Peraturan BKN Nomor 3 Tahun 2023.',
                   'Instansi pembina jabatan fungsional bertanggung jawab menetapkan standar kompetensi dan menjamin kualitas pembinaan.')],
            ['kegiatan', 'Sosialisasi Perubahan Nomenklatur Jabatan Fungsional dan Konversi Angka Kredit',
                'Pemaparan menjelaskan penyesuaian nomenklatur dan cara konversi angka kredit yang telah dimiliki.',
                $p('Sosialisasi ini ditujukan bagi pejabat fungsional dan pengelola kepegawaian agar memahami penyesuaian nomenklatur jabatan fungsional serta tata cara konversi angka kredit.',
                   'Narasumber menekankan pentingnya pemutakhiran data pada sistem kepegawaian agar proses penyesuaian berjalan tanpa hambatan.')],
            ['pengumuman', 'Hasil Uji Kompetensi Periode III Tahun 2026 Dapat Diakses Peserta',
                'Peserta dapat melihat hasil ujikom melalui akun masing-masing pada sistem ujikom.',
                $p('Hasil uji kompetensi periode III Tahun 2026 telah diumumkan. Peserta dapat memeriksa hasil melalui akun pada laman ujikom.',
                   'Peserta yang belum memenuhi syarat kelulusan dapat mengikuti ujikom pada periode berikutnya sesuai ketentuan.',
                   'Pertanyaan terkait hasil dapat disampaikan melalui layanan Konsultasi Online dengan kategori Uji Kompetensi.')],
            ['kegiatan', 'Workshop Pemanfaatan Dashboard JFK untuk Perencanaan Kebutuhan Jabatan Fungsional',
                'Dashboard menyajikan sebaran pejabat fungsional per jenjang, instansi, dan wilayah.',
                $p('Workshop memperkenalkan fitur Dashboard JFK untuk membantu instansi merencanakan kebutuhan formasi jabatan fungsional kepegawaian berdasarkan data aktual.',
                   'Peserta berlatih membaca grafik sebaran jenjang, tren pengangkatan, dan rasio pejabat fungsional terhadap beban kerja.')],
            ['regulasi', 'UU Nomor 20 Tahun 2023 tentang ASN: Implikasinya bagi Pembinaan Jabatan Fungsional',
                'Undang-undang baru menegaskan sistem merit dan penataan manajemen ASN berbasis digital.',
                $p('Undang-Undang Nomor 20 Tahun 2023 tentang Aparatur Sipil Negara menegaskan penerapan sistem merit dalam manajemen ASN, termasuk pada pembinaan jabatan fungsional.',
                   'Pengelolaan data dan layanan kepegawaian didorong semakin terintegrasi secara digital sehingga proses menjadi lebih cepat dan akuntabel.')],
            ['pengumuman', 'Perbaikan Sistem Terjadwal: Layanan Daring Tidak Tersedia Sementara',
                'Pemeliharaan rutin dilakukan di luar jam kerja untuk menjaga keandalan layanan.',
                $p('Dalam rangka peningkatan keandalan sistem, sebagian layanan daring akan dihentikan sementara pada akhir pekan sesuai jadwal pemeliharaan.',
                   'Mohon maaf atas ketidaknyamanannya. Informasi pembaruan akan diumumkan melalui portal ini.')],
            ['kegiatan', 'Rapat Koordinasi Pembina JF dengan Instansi Pengguna: Menyelaraskan Standar Kompetensi',
                'Rakor membahas keselarasan standar kompetensi dan kebutuhan pengembangan pejabat fungsional.',
                $p('Rapat koordinasi dihadiri perwakilan instansi pusat dan daerah untuk menyelaraskan standar kompetensi serta mekanisme pengembangan kompetensi pejabat fungsional.',
                   'Hasil rakor akan dituangkan dalam rencana aksi pembinaan tahun berikutnya.')],
            ['pengumuman', 'Panduan Mengisi Survei Kepuasan Layanan Direktorat JF MASN',
                'Survei dapat diisi dalam kurang dari tiga menit dan menjadi dasar perbaikan layanan.',
                $p('Kami mengundang seluruh pengguna layanan untuk mengisi Survei Kepuasan Layanan. Penilaian Anda dipakai untuk menghitung indeks kepuasan dan menjadi masukan perbaikan.',
                   'Survei dapat diakses melalui menu Survei Layanan di beranda portal.')],
            ['regulasi', 'Perpres Nomor 92 Tahun 2024 tentang Badan Kepegawaian Negara',
                'Peraturan presiden yang mengatur kedudukan, tugas, dan fungsi BKN dalam manajemen ASN.',
                $p('Perpres Nomor 92 Tahun 2024 mengatur organisasi dan fungsi BKN, termasuk perumusan kebijakan teknis manajemen ASN dan pengawasan penerapan sistem merit.',
                   'Pembinaan jabatan fungsional di bidang kepegawaian dilaksanakan di bawah koordinasi unit pembinaan penyelenggaraan manajemen ASN.')],
        ];

        $total = count($posts);
        foreach ($posts as $i => [$slugCat, $judul, $ringkas, $isi]) {
            $tgl = now()->subDays(($total - $i) * 6 + mt_rand(0, 3));
            $slug = Str::slug($judul);
            DB::table('posts')->insert([
                'category_id' => $cat[$slugCat] ?? 1,
                'user_id' => $uid,
                'title' => $judul,
                'slug' => $slug,
                'excerpt' => $ringkas,
                'body' => $isi,
                'image' => $this->simpan('post-image', "berita-$slug", fn ($p2) => DummyImage::card($p2, $judul, ucfirst($slugCat))),
                'views' => mt_rand(40, 2400),
                'publish_at' => $tgl->format('Y-m-d'),
                'created_at' => $tgl, 'updated_at' => $tgl,
            ]);
        }
    }

    // ---------------------------------------------------------------- kegiatan

    private function kegiatan(): void
    {
        $rows = [
            // [nama, jenis, offset hari (negatif = lalu), desc]
            ['Bimtek Penyusunan SKP dan Penetapan Angka Kredit', 'Bimtek', -75, 'Bimbingan teknis bagi operator kepegawaian dan pejabat fungsional.'],
            ['Ujikompetensi Kenaikan Jenjang Periode II', 'Uji Kompetensi', -150, 'Uji kompetensi kenaikan jenjang JF Kepegawaian periode II.'],
            ['Ujikompetensi Kenaikan Jenjang Periode III', 'Uji Kompetensi', -70, 'Uji kompetensi kenaikan jenjang JF Kepegawaian periode III.'],
            ['Sosialisasi Perubahan Nomenklatur dan Konversi Angka Kredit', 'Sosialisasi', -45, 'Sosialisasi penyesuaian nomenklatur dan konversi angka kredit.'],
            ['Workshop Dashboard JFK untuk Perencanaan Kebutuhan', 'Workshop', -30, 'Pelatihan membaca dan memanfaatkan Dashboard JFK.'],
            ['Rapat Koordinasi Pembina JF dengan Instansi Pengguna', 'Rapat Koordinasi', -14, 'Penyelarasan standar kompetensi dan rencana pembinaan.'],
            ['Konsultasi Online Senin', 'Konsultasi', 5, 'Sesi konsultasi daring seputar JF Kepegawaian, setiap Senin.'],
            ['Konsultasi Online Rabu', 'Konsultasi', 7, 'Sesi konsultasi daring seputar uji kompetensi, setiap Rabu.'],
            ['Ujikompetensi Kenaikan Jenjang Periode IV', 'Uji Kompetensi', 12, 'Uji kompetensi kenaikan jenjang JF Kepegawaian periode IV.'],
            ['Sosialisasi Aplikasi Ujikom dan Verifikasi Sertifikat', 'Sosialisasi', 21, 'Pengenalan fitur aplikasi ujikom, QR sertifikat, dan presensi daring.'],
            ['Bimtek Penilai Angka Kredit Jabatan Fungsional', 'Bimtek', 35, 'Peningkatan kapasitas tim penilai angka kredit instansi.'],
        ];

        $faker = \Faker\Factory::create('id_ID');
        $instansi = ['Kementerian Keuangan', 'Kementerian Kesehatan', 'Pemerintah Provinsi Jawa Barat', 'Pemerintah Kota Surabaya', 'Kementerian Agama',
            'Pemerintah Kabupaten Sleman', 'Kementerian Pendidikan', 'Pemerintah Provinsi Sumatera Utara', 'Kantor Regional BKN', 'Pemerintah Kota Makassar'];
        $jabatan = ['Analis SDM Aparatur Ahli Pertama', 'Analis SDM Aparatur Ahli Muda', 'Analis SDM Aparatur Ahli Madya', 'Pengelola Kepegawaian', 'Operator Kepegawaian', 'Arsiparis Ahli Muda'];

        foreach ($rows as [$nama, $jenis, $off, $desc]) {
            $waktu = now()->addDays($off)->setTime(mt_rand(8, 13), 0);
            $slug = Str::slug($nama);
            $id = DB::table('kegiatans')->insertGetId([
                'nama' => $nama, 'slug' => $slug, 'deskripsi' => $desc,
                'waktu' => $waktu->format('Y-m-d H:i:s'),
                'batas_presensi' => $off < 0 ? $waktu->copy()->addHours(6)->format('Y-m-d H:i:s') : null,
                'link' => 'https://zoom.example.go.id/j/' . mt_rand(100000000, 999999999),
                'jenis' => $jenis,
                'image' => $this->simpan('post-image', "kegiatan-$slug", fn ($p) => DummyImage::card($p, $nama, $jenis)),
                'status' => '1',
                'created_at' => $waktu->copy()->subDays(10), 'updated_at' => now(),
            ]);

            if ($off < 0) {
                // Peserta hadir (fiktif) untuk kegiatan yang sudah lewat.
                $n = mt_rand(12, 30);
                for ($i = 0; $i < $n; $i++) {
                    DB::table('absensis')->insert([
                        'kegiatan_id' => $id,
                        'nip' => '19' . mt_rand(70, 99) . sprintf('%02d%02d', mt_rand(1, 12), mt_rand(1, 28)) . '20' . mt_rand(0, 24) . mt_rand(1, 2) . sprintf('%03d', mt_rand(1, 999)),
                        'nama' => $faker->name(), 'email' => $faker->unique()->safeEmail(),
                        'jabatan' => $jabatan[array_rand($jabatan)], 'instansi' => $instansi[array_rand($instansi)],
                        'status' => '1', 'created_at' => $waktu->copy()->addMinutes(mt_rand(0, 60)), 'updated_at' => $waktu,
                    ]);
                }
                // Materi paparan untuk kegiatan sosialisasi/bimtek/workshop.
                if (in_array($jenis, ['Bimtek', 'Sosialisasi', 'Workshop'])) {
                    foreach (['Materi Utama', 'Studi Kasus & Simulasi'] as $k => $judul) {
                        $rel = "materi/$slug-" . ($k + 1) . '.pdf';
                        $this->tulisPdf("{$this->disk}/$rel", "$nama — $judul");
                        DB::table('materi_paparans')->insert([
                            'kegiatan_id' => $id, 'judul' => "$judul – $nama", 'file' => $rel,
                            'keterangan' => 'Dokumen contoh (dummy).', 'urutan' => $k,
                            'created_at' => now(), 'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }

    /** PDF satu halaman minimal agar tautan unduh materi bisa dibuka. */
    private function tulisPdf(string $path, string $judul): void
    {
        @mkdir(dirname($path), 0775, true);
        $t = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], mb_convert_encoding($judul, 'ISO-8859-1', 'UTF-8'));
        $stream = "BT /F1 18 Tf 60 760 Td ($t) Tj 0 -30 Td /F1 11 Tf (Dokumen contoh untuk data dummy Portal Direktorat JF MASN.) Tj ET";
        $objs = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>',
            '<< /Length ' . strlen($stream) . " >>\nstream\n$stream\nendstream",
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
        ];
        $pdf = "%PDF-1.4\n";
        $off = [];
        foreach ($objs as $i => $o) {
            $off[] = strlen($pdf);
            $pdf .= ($i + 1) . " 0 obj\n$o\nendobj\n";
        }
        $x = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objs) + 1) . "\n0000000000 65535 f \n";
        foreach ($off as $o) {
            $pdf .= sprintf("%010d 00000 n \n", $o);
        }
        $pdf .= "trailer\n<< /Size " . (count($objs) + 1) . " /Root 1 0 R >>\nstartxref\n$x\n%%EOF";
        file_put_contents($path, $pdf);
    }

    // --------------------------------------------------------------------- faq

    private function faq(): void
    {
        $rows = [
            ['Uji Kompetensi', 'Berapa kali uji kompetensi dilaksanakan dalam setahun?', 'Uji kompetensi dilaksanakan empat periode dalam setahun, yaitu Februari, April, Juli, dan Oktober. Batas pendaftaran masing-masing periode tercantum pada halaman Jadwal Ujikom.'],
            ['Uji Kompetensi', 'Apakah ada biaya untuk mengikuti uji kompetensi?', 'Tidak ada. Seluruh layanan uji kompetensi tidak dipungut biaya. Waspadai pihak yang mengatasnamakan BKN dan meminta pembayaran.'],
            ['Uji Kompetensi', 'Bagaimana jika saya belum lulus uji kompetensi?', 'Anda dapat mengusulkan kembali untuk mengikuti uji kompetensi pada periode berikutnya sepanjang persyaratan masih terpenuhi.'],
            ['Angka Kredit', 'Apa perbedaan penilaian angka kredit sekarang dan sebelumnya?', 'Berdasarkan Peraturan BKN Nomor 3 Tahun 2023, angka kredit dinilai berbasis kinerja melalui Sasaran Kinerja Pegawai (SKP), bukan lagi berbasis butir kegiatan.'],
            ['Angka Kredit', 'Dokumen apa saja yang diperlukan untuk usul penetapan angka kredit (PAK)?', 'Umumnya meliputi SKP dan penilaian kinerja, keputusan pengangkatan dalam jabatan, serta dokumen pendukung lain sesuai jenis pengusulan. Rincian ada pada halaman layanan Pengusulan PAK.'],
            ['Layanan', 'Bagaimana cara memantau jawaban konsultasi saya?', 'Setelah mengirim konsultasi Anda akan mendapat nomor tiket. Masukkan nomor tersebut pada halaman Cari Tiket untuk melihat status dan jawaban.'],
            ['Layanan', 'Bagaimana mengunduh sertifikat kegiatan?', 'Isi presensi dan survei kepuasan pada kegiatan yang Anda ikuti, lalu unduh sertifikat dari halaman yang tersedia. Keaslian sertifikat dapat dicek melalui menu Verifikasi Sertifikat.'],
            ['Layanan', 'Jam layanan apa saja yang berlaku?', 'Layanan tatap muka dan konsultasi tersedia Senin–Jumat pukul 08.00–16.00 WIB. Layanan daring dapat diakses setiap saat kecuali saat pemeliharaan sistem.'],
        ];
        foreach ($rows as $i => [$kat, $q, $a]) {
            DB::table('faqs')->insert(['kategori' => $kat, 'pertanyaan' => $q, 'jawaban' => $a, 'urutan' => $i, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    // -------------------------------------------------------------- repository

    private function repository(): void
    {
        $rows = [
            ['Undang-Undang Nomor 20 Tahun 2023 tentang Aparatur Sipil Negara', 'Undang-Undang', 'Mengatur ASN, sistem merit, dan manajemen ASN.', 'https://peraturan.bpk.go.id/Details/269470/uu-no-20-tahun-2023', 'published'],
            ['Peraturan Menteri PAN-RB Nomor 1 Tahun 2023 tentang Jabatan Fungsional', 'Permen PAN-RB', 'Pengelolaan jabatan fungsional: jenjang, pengangkatan, kenaikan jenjang.', 'https://jdih.menpan.go.id', 'published'],
            ['Peraturan BKN Nomor 3 Tahun 2023 tentang Angka Kredit, Kenaikan Pangkat, dan Jenjang Jabatan Fungsional', 'Peraturan BKN', 'Angka kredit berbasis kinerja (SKP) dan ketentuan kenaikan pangkat/jenjang.', 'https://www.bkn.go.id/regulasi/peraturan-bkn-nomor-3-tahun-2023/', 'published'],
            ['Buku Panduan Teknis Peraturan BKN Nomor 3 Tahun 2023', 'Panduan', 'Panduan teknis pelaksanaan Perban 3/2023.', 'https://www.bkn.go.id/unggahan/2024/04/Buku-Panduan-Teknis-PerBKN-3-Tahun-2023.pdf', 'published'],
            ['Peraturan Presiden Nomor 92 Tahun 2024 tentang Badan Kepegawaian Negara', 'Perpres', 'Kedudukan, tugas, dan fungsi BKN.', 'https://jdih.bkn.go.id/common/dokumen/2024perpres92-2576.pdf', 'published'],
            ['Panduan Penggunaan Sistem Ujikom bagi Operator Instansi', 'Panduan', 'Langkah registrasi operator, pengusulan peserta, dan unduh kartu peserta.', null, 'published'],
            ['Prosedur Internal Penanganan Usul Angka Kredit', 'Internal', "Alur internal (tidak dipublikasikan): (1) berkas usul diterima melalui sistem, (2) verifikasi kelengkapan oleh Pokja, (3) penilaian oleh tim penilai, (4) penetapan PAK oleh pejabat berwenang, (5) notifikasi hasil kepada pemohon. Dipakai sebagai pengetahuan untuk menjawab pertanyaan pengunjung melalui chat.", null, 'internal'],
        ];
        foreach ($rows as [$judul, $jenis, $desc, $link, $status]) {
            DB::table('jdihjfks')->insert([
                'title' => $judul, 'deskripsi' => $desc, 'link' => $link,
                'image' => $status === 'published' ? $this->simpan('post-image', 'repo-' . Str::slug(Str::limit($judul, 50, '')), fn ($p) => DummyImage::cover($p, $judul, $jenis)) : null,
                'status' => $status, 'created_at' => now(), 'updated_at' => now(),
            ]);
        }
    }

    // ------------------------------------------------------ basis pengetahuan

    private function pengetahuan(): void
    {
        $rows = [
            ['Jadwal Uji Kompetensi', 'Ujikom', 'jadwal ujikom periode pendaftaran februari april juli oktober', 'Uji kompetensi JF Kepegawaian dilaksanakan 4 periode per tahun: Periode I (Februari, daftar sampai akhir Desember tahun sebelumnya), Periode II (April, daftar sampai akhir Februari), Periode III (Juli, daftar sampai akhir Mei), Periode IV (Oktober, daftar sampai akhir Agustus). Seluruhnya daring dan tanpa biaya.'],
            ['Dasar Hukum Angka Kredit', 'Angka Kredit', 'angka kredit peraturan bkn 3 2023 skp kinerja', 'Angka kredit diatur Peraturan BKN Nomor 3 Tahun 2023 (pelaksanaan Permen PAN-RB Nomor 1 Tahun 2023). Penilaian berbasis kinerja melalui Sasaran Kinerja Pegawai (SKP), bukan butir kegiatan.'],
            ['Cara Konsultasi dan Nomor Tiket', 'Layanan', 'konsultasi tiket jawaban status', 'Konsultasi diajukan lewat menu Konsultasi Online dan menghasilkan nomor tiket. Gunakan nomor tersebut di halaman Cari Tiket untuk melihat jadwal, PIC, dan jawaban.'],
            ['Sertifikat Kegiatan', 'Layanan', 'sertifikat unduh verifikasi qr presensi survei', 'Sertifikat dapat diunduh setelah mengisi presensi dan survei kegiatan. Keaslian diperiksa lewat menu Verifikasi Sertifikat memakai nomor atau QR.'],
            ['Kontak dan Jam Layanan', 'Umum', 'alamat telepon email jam operasional kontak', 'Alamat: Gedung II Kantor Pusat BKN, Jl. Mayjen Sutoyo No. 12, Cililitan, Jakarta Timur. Telepon (021) 8093008. Jam layanan Senin–Jumat 08.00–16.00 WIB.'],
            ['Biaya Layanan', 'Umum', 'biaya gratis pungutan', 'Seluruh layanan Direktorat JF MASN tidak dipungut biaya. Laporkan pihak yang meminta pembayaran mengatasnamakan BKN.'],
        ];
        foreach ($rows as $i => [$judul, $kat, $kw, $isi]) {
            DB::table('pengetahuans')->insert(['judul' => $judul, 'kategori' => $kat, 'kata_kunci' => $kw, 'isi' => $isi, 'aktif' => 1, 'urutan' => $i, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    // -------------------------------------------------------------- sertifikat

    private function sertifikat(): void
    {
        DB::table('pengaturan_sertifikats')->insert(['prefix' => 'JFMASN', 'digit_urut' => 4, 'reset_tahunan' => 1, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('sertifikat_templates')->insert([
            'nama' => 'Template Standar Kegiatan', 'warna_aksen' => '#0e52a0',
            'teks_pembuka' => 'Diberikan kepada',
            'teks_keterangan' => 'Atas partisipasinya sebagai peserta dalam kegiatan yang diselenggarakan oleh Direktorat Jabatan Fungsional Manajemen ASN, Badan Kepegawaian Negara.',
            'nama_penandatangan' => 'Dr. Bagus Prasetyo Wicaksono, M.Si.', 'jabatan_penandatangan' => 'Direktur Jabatan Fungsional MASN',
            'is_default' => 1, 'created_at' => now(), 'updated_at' => now(),
        ]);
    }

    // -------------------------------------------------------------- konsultasi

    private function konsultasi(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $topik = [
            1 => ['Syarat pengangkatan pertama dalam JF Analis SDM Aparatur', 'Konversi angka kredit setelah perubahan nomenklatur', 'Perpindahan dari jabatan administrasi ke JF', 'Usul formasi JF Kepegawaian untuk tahun depan'],
            2 => ['Jadwal ujikom periode berikutnya', 'Hasil ujikom belum muncul pada akun', 'Syarat mengikuti ujikom kenaikan jenjang', 'Kendala login aplikasi CBT'],
            3 => ['Permohonan pembinaan JF di instansi kami', 'Penyusunan SKP bagi pejabat fungsional', 'Jadwal bimtek penilai angka kredit'],
        ];
        $instansi = ['Kementerian Keuangan', 'Pemerintah Kota Bandung', 'Kementerian Kesehatan', 'Pemerintah Provinsi Kalimantan Timur', 'Kementerian Agama', 'Pemerintah Kabupaten Bantul'];
        $pic = array_column(DB::table('organisasi_units')->where('unit', 'like', 'Pokja%')->whereNotNull('parent_id')->get(['nama'])->all(), 'nama') ?: ['Admin'];

        $n = 0;
        foreach ($topik as $kode => $list) {
            foreach ($list as $ket) {
                $n++;
                $tgl = now()->subDays(mt_rand(1, 60))->setTime(mt_rand(8, 15), 0);
                $dijawab = mt_rand(0, 100) < 70;
                DB::table('konsultasis')->insert([
                    'nip' => '19' . mt_rand(70, 99) . sprintf('%02d%02d', mt_rand(1, 12), mt_rand(1, 28)) . '2010' . mt_rand(1, 2) . sprintf('%03d', mt_rand(1, 999)),
                    'nama' => $faker->name(), 'email' => $faker->unique()->safeEmail(),
                    'instansi' => $instansi[array_rand($instansi)], 'kode_id' => $kode,
                    'jadwal' => $tgl, 'jadwalfix' => $dijawab ? $tgl->copy()->addDay() : null,
                    'link' => $dijawab ? 'https://zoom.example.go.id/j/' . mt_rand(100000000, 999999999) : null,
                    'pic' => $dijawab ? $pic[array_rand($pic)] : null,
                    'keterangan' => $ket,
                    'tiket' => sprintf('%03d-%s-%03d', $kode, $tgl->format('ymd'), $n),
                    'jawab' => $dijawab ? 1 : 0,
                    'created_at' => $tgl, 'updated_at' => $tgl,
                ]);
            }
        }
    }
}
