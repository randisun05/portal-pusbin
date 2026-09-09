<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Dashboard;
use App\Models\highlight;
use App\Models\JadwalUkom;
use App\Models\Jdihjfk;
use App\Models\Kegiatan;
use App\Models\KodeKonsultasi;
use App\Models\Konsultasi;
use App\Models\Layanan;
use App\Models\MisiItem;
use App\Models\OrganisasiUnit;
use App\Models\Permission;
use App\Models\Post;
use App\Models\Profil;
use App\Models\Role;
use App\Models\Survei;
use App\Models\SurveiIndikator;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $superAdminRole = Role::create([
            'name' => Role::SUPER_ADMIN,
            'label' => 'Super Admin',
            'deskripsi' => 'Akses penuh ke seluruh modul, termasuk manajemen admin & role.',
        ]);

        $adminRole = Role::create([
            'name' => Role::ADMIN,
            'label' => 'Admin',
            'deskripsi' => 'Akses ke seluruh modul operasional & konten, tanpa manajemen admin.',
        ]);

        $editorRole = Role::create([
            'name' => Role::EDITOR,
            'label' => 'Editor',
            'deskripsi' => 'Akses terbatas pada modul Publikasi, Layanan, Kegiatan, dan Highlight.',
        ]);

        $permissionIds = [];
        foreach (Permission::definitions() as $grup => $items) {
            foreach ($items as $slug => $label) {
                $permissionIds[$slug] = Permission::create([
                    'slug' => $slug,
                    'label' => $label,
                    'grup' => $grup,
                ])->id;
            }
        }

        // Admin: semua permission kecuali manajemen admin/role.
        $adminRole->permissions()->sync(collect($permissionIds)->except('manage-users')->values());

        // Editor: hanya modul konten.
        $editorRole->permissions()->sync(collect($permissionIds)->only([
            'manage-publikasi', 'manage-layanan', 'manage-kegiatan', 'manage-highlight', 'manage-comment', 'manage-faq',
        ])->values());

        User::create([
            'name' => 'Administrator',
            'username' => 'administrator',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => $superAdminRole->id,

        ]);


        Category::create([
            'name' => 'Pengumuman',
            'slug' => 'pengumuman',

        ]);

        Category::create([
            'name' => 'Regulasi',
            'slug' => 'regulasi',

        ]);

        Category::create([
            'name' => 'Kegiatan',
            'slug' => 'kegiatan',

        ]);

        Layanan::create([
            'nama' => "Web",
            'deskripsi' => "Kunjungi Web Kami",
            'link' => "/webpusbin",
            'image' => "post-image\website.png",
        ]);

        Layanan::create([
            'nama' => "Pendaftaran Ujikom",
            'deskripsi' => "Pendaftaran Ujikom",
            'link' => "/ujikom.bkn.go.id",
            'image' => "post-image\logoukom.png",
        ]);

        Layanan::create([
            'nama' => "CBT",
            'deskripsi' => "CBT",
            'link' => "/ujikom.bkn.go.id",
            'image' => "post-image\cbt.webp",
        ]);



        Layanan::create([
            'nama' => "Konsultasi Online",
            'deskripsi' => "Konsultasi Online",
            'link' => "/konsultasi",
            'image' => "post-image\konsul.png",
        ]);

        Layanan::create([
            'nama' => "Dashboard JFK",
            'deskripsi' => "Dashboard JFK",
            'link' => "https://dashboard.skom.id/",
            'image' => "post-image\data.png",
        ]);

        Layanan::create([
            'nama' => "Peraturan Terkait JFK",
            'deskripsi' => "Dashboard JFK",
            'link' => "/jdihjfk",
            'image' => "post-image\jdih.png",
        ]);



        Layanan::create([
            'nama' => "Absensi",
            'deskripsi' => "Absensi Kegiatan",
            'link' => "/absensi",
            'image' => "post-image\absen.png",
        ]);

        Layanan::create([
            'nama' => "Survei Layanan",
            'deskripsi' => "Survei Layanan",
            'link' => "/survei",
            'image' => "post-image\survei.png",
        ]);


        // Konsultasi::create([
        //     'nip' => "123",
        //     'perihal' => "Konsultasi",
        //     'jadwal' => "12-12-12",
        // ]);


        JadwalUkom::create([
            'periode' => 'I',
            'bulan' => 'Februari',
            'batasdaftar' => 'Akhir Desember Tahun Sebelumnya',
        ]);
        JadwalUkom::create([
            'periode' => 'II',
            'bulan' => 'April',
            'batasdaftar' => 'Akhir Februari Tahun Berjalan',
        ]);
        JadwalUkom::create([
            'periode' => 'III',
            'bulan' => 'Juli',
            'batasdaftar' => 'Akhir Mei Tahun Berjalan',
        ]);
        JadwalUkom::create([
            'periode' => 'IV',
            'bulan' => 'Oktober',
            'batasdaftar' => 'Akhir Agustus Tahun Berjalan',
        ]);

        Kegiatan::create([
            'nama' => 'Konsultasi Senin',
            'slug' => 'konsultasi-online-senin',
            'waktu' => '2024-03-22',
            'link' => 'www.konsultasi.com',
            'jenis' => 'Konsultasi',
            'image' => 'image',
        ]);

        Kegiatan::create([
            'nama' => 'Konsultasi Selasa',
            'slug' => 'konsultasi-online-selasa',
            'waktu' => '2024-03-22',
            'link' => 'www.konsultasi.com',
            'jenis' => 'Konsultasi',
            'image' => 'image',
        ]);

        Kegiatan::create([
            'nama' => 'Konsultasi Rabu',
            'slug' => 'konsultasi-online-rabu',
            'waktu' => '2024-03-22',
            'link' => 'www.konsultasi.com',
            'jenis' => 'Konsultasi',
            'image' => 'image',
        ]);

        Kegiatan::create([
            'nama' => 'Ujikompetensi Kenaikan Jenjang Periode I',
            'slug' => 'ujikompetensi-kenaikan-jenjang-periode-1',
            'waktu' => '2024-03-22',
            'link' => 'www.konsultasi.com',
            'jenis' => 'Uji Kompetensi',
            'image' => 'image',
        ]);
        Kegiatan::create([
            'nama' => 'Pemaparan Perubahan Nomenklatur Baru',
            'slug' => 'pemaparan-perubahan-nomenklatur-baru',
            'waktu' => '2024-03-22',
            'link' => 'www.konsultasi.com',
            'jenis' => 'Sosialisasi',
            'image' => 'image',
        ]);


        Post::factory(20)->create();

        KodeKonsultasi::create([
            'jenis' => 'Jabatan Fungsional Kepegawaian',
            'kode' => '001',
        ]);

        KodeKonsultasi::create([
            'jenis' => 'Uji Kompetensi',
            'kode' => '002',
        ]);

        KodeKonsultasi::create([
            'jenis' => 'Pembinaan',
            'kode' => '003',
        ]);


        highlight::create([
            'name' => 'Highlight 1',
            'desc' => 'Highlight 1',
            'image' => 'post-image\high(1).png',
        ]);

        highlight::create([
            'name' => 'Highlight 2',
            'desc' => 'Highlight 2',
            'image' => 'post-image\high(2).png',
        ]);

        highlight::create([
            'name' => 'Highlight 3',
            'desc' => 'Highlight 3',
            'image' => 'post-image\high(3).png',
        ]);

        Survei::create([
            'title' => 'Pengumpulan Data JFK',
            'type' => '1'
        ]);

        Survei::create([
            'title' => 'Pengumpulan Data Quesioner',
            'type' => '2'
        ]);

        Survei::create([
            'title' => 'Survei Pelaksanaan Pelatihan',
            'type' => '3'
        ]);

        Survei::create([
            'title' => 'Survei Kepuasan Layanan Direktorat JF MASN',
            'type' => '4'
        ]);
        Survei::create([
            'title' => 'Survei Pelaksanaan Ujikompetensi',
            'type' => '5'
        ]);

        SurveiIndikator::create([
            'title' => 'Bagaimana Kwalitas Uji Kompetensi',
        ]);

        SurveiIndikator::create([
            'title' => 'Bagaimana Kwalitas Rekomenasi Kebutuhan',
        ]);

        SurveiIndikator::create([
            'title' => 'Bagaimana pendapat Anda tentang proses penilaian dan penetapan Angka Kredit?',
        ]);
        SurveiIndikator::create([
            'title' => 'Bagaimana pendapat Anda tentang pemberian dan pengiriman Rekomendasi/ Pertimbangan Pengangkatan ?',
        ]);
        SurveiIndikator::create([
            'title' => 'Bagaimana pendapat Anda tentang proses perhitungan kebutuhan formasi Jabatan Fungsional Kepegawaian?',
        ]);
        SurveiIndikator::create([
            'title' => 'Bagaimana pendapat Anda tentang bahan/ data Jabatan Fungsional Kepegawaian?',
        ]);
        SurveiIndikator::create([
            'title' => 'Bagaimana pendapat Anda tentang pelaksanaan Uji Kompetensi Jabatan Fungsional Kepegawaian?',
        ]); SurveiIndikator::create([
            'title' => 'Bagaimana pendapat Anda tentang pelaksanaan fasilitasi/ sosialisasi/ bimtek/ workshop Jabatan Fungsional Kepegawaian?',
        ]);
        SurveiIndikator::create([
            'title' => 'Nama',
        ]);
        SurveiIndikator::create([
            'title' => 'No HP',
        ]);
        SurveiIndikator::create([
            'title' => 'Link',
        ]);





        Jdihjfk::create([
            'title' => 'Peraturan BKN Nomor 3 Tahun 2023',
            'deskripsi' => 'Peraturan BKN Nomor 3 Tahun 2023 tentang Angka Kredit, Kenaikan Pangkat dan Jenjang Jabatan Fungsional',
            'link' => 'https://www.bkn.go.id/regulasi/peraturan-bkn-nomor-3-tahun-2023/',
            'image' => 'post-image/perbkn_3.png',
        ]);

        Jdihjfk::create([
            'title' => 'Undang-undang (UU) Nomor 20 Tahun 2023 tentang Aparatur Sipil Negara',
            'deskripsi' => 'UU ini mengatur tentang Aparatur Sipil Negara dengan menetapkan batasan istilah yang digunakan dalam pengaturannya. Pokok-pokok pengaturan yang terdapat di dalam Undang-Undang ini',
            'link' => 'https://peraturan.bpk.go.id/Details/269470/uu-no-20-tahun-2023',
            'image' => 'post-image/uu_20.png',
        ]);

        $kapus = OrganisasiUnit::create([
            'nama' => 'Dr. Achmad Slamet Hidayat, S.Pd., M.Si.',
            'jabatan' => 'Direktur Jabatan Fungsional MASN',
            'unit' => 'Pimpinan',
            'urutan' => 0,
        ]);

        $pokja = [
            ['nama' => 'Sarni, S.E.', 'jabatan' => 'Analis SDM Aparatur Ahli Madya', 'unit' => 'Pokja 1'],
            ['nama' => 'Agung Sugiarto, S.H., M.H.', 'jabatan' => 'Analis SDM Aparatur Ahli Madya', 'unit' => 'Pokja 2'],
            ['nama' => 'Tauchid Djatmiko, S.H., M.Si.', 'jabatan' => 'Analis SDM Aparatur Ahli Utama', 'unit' => 'Pokja 3'],
            ['nama' => 'Dr. Elin Cahyaningsih, S.Kom., MMSI.', 'jabatan' => 'Analis SDM Aparatur Ahli Madya', 'unit' => 'Pokja 4'],
        ];

        foreach ($pokja as $i => $data) {
            OrganisasiUnit::create(array_merge($data, [
                'parent_id' => $kapus->id,
                'urutan' => $i + 1,
            ]));
        }

        Profil::create([
            'tentang' => "Direktorat Jabatan Fungsional Manajemen Aparatur Sipil Negara (Direktorat JF MASN) adalah unit kerja Badan Kepegawaian Negara (BKN) yang bertugas melaksanakan pembinaan jabatan fungsional di bidang kepegawaian, meliputi penyusunan kebutuhan formasi, uji kompetensi, penilaian angka kredit, serta pengembangan kompetensi bagi para pejabat fungsional kepegawaian di seluruh Indonesia.\n\nKami berkomitmen memberikan layanan yang profesional, transparan, dan mudah diakses, baik secara daring maupun luring, guna mendukung peningkatan profesionalisme Aparatur Sipil Negara (ASN) khususnya pada rumpun jabatan fungsional kepegawaian.",
            'visi' => 'Menjadi direktorat pembinaan jabatan fungsional manajemen ASN yang profesional, kredibel, dan berbasis teknologi dalam mendukung terwujudnya ASN yang kompeten dan berkinerja tinggi.',
            'alamat' => 'Jl. Mayjen Sutoyo No. 12, Jakarta Timur, 13640 – Indonesia',
            'telepon' => '021-8093008',
            'email' => 'pusbinjfk@gmail.com',
            'jam_operasional' => 'Senin - Jumat, 08.00 - 16.00 WIB',
        ]);

        $misis = [
            'Menyusun kebutuhan dan formasi jabatan fungsional kepegawaian secara akurat dan berkelanjutan.',
            'Menyelenggarakan uji kompetensi jabatan fungsional kepegawaian yang objektif dan transparan.',
            'Melaksanakan penilaian dan penetapan angka kredit secara tepat waktu.',
            'Mengembangkan kompetensi pejabat fungsional kepegawaian melalui pelatihan dan bimbingan teknis.',
            'Memberikan layanan konsultasi dan informasi jabatan fungsional kepegawaian yang responsif.',
        ];

        foreach ($misis as $i => $isi) {
            MisiItem::create([
                'isi' => $isi,
                'urutan' => $i,
            ]);
        }
    }

}
