<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Halaman layanan yang tampil di menu "Layanan" pada navbar publik.
     * Menggantikan view statis public/layanan/*.blade.php agar nama, ikon,
     * urutan, dan isi halamannya bisa dikelola dari admin.
     */
    public function up()
    {
        Schema::create('layanan_halamans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('judul');
            $table->longText('konten')->nullable();
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        $halaman = [
            [
                'nama' => 'Usul Formasi JFK',
                'slug' => 'pengajuan-rekomendasi',
                'judul' => 'Rekomendasi Kebutuhan Jabatan Fungsional Kepegawaian',
                'urutan' => 1,
                'konten' => <<<'HTML'
<p>Untuk mewujudkan kesesuaian jumlah Jabatan Fungsional Kepegawaian (JFK) dengan beban kerja dan kebutuhan organisasi pada instansi pemerintah, diperlukan pedoman saat melakukan penyusunan kebutuhan JFK. Pedoman penyusunan kebutuhan Jabatan Fungsional Kepegawaian ini menjadi acuan bagi instansi pembina dan instansi pengguna dalam menyusun kebutuhan setiap jabatan fungsional Kepegawaiannya berdasarkan jenjang jabatannya. Secara teknis, ada 4 (empat) tahapan yang harus dilakukan saat penyusunan kebutuhan JFK sesuai Peraturan BKN, yakni mulai dari (1)Menyusun Standar Kebutuhan Rata-rata (SKR) dan Persentase Kontribusi, (2)Penghitungan Volume Beban Kerja, (3)Penghitungan Kebutuhan, dan (4)Penyusunan Peta Jabatan.</p>
<p>Berikut dokumen pedoman penyusunan kebutuhan Jabatan Fungsional Kepegawaian berdasarkan jabatan fungsional : </p>
<p class="mb-0">Analis Sumber Daya Manusia Aparatur</p>
<p><a href="/dokumen/perbknno2thn2022.pdf">Peraturan BKN No. 2 Tahun 2022 </a></p>
<p class="mb-0">Pranata Sumber Daya Manusia Aparatur</p>
<p><a href="/dokumen/perbknno3thn2022.pdf">Peraturan BKN No. 3 Tahun 2022</a></p>
<p class="mb-0">Asesor Sumber Daya Manusia Aparatur</p>
<p><a href="/dokumen/perbknno4thn2022.pdf">Peraturan BKN No. 3 Tahun 2022</a></p>

<p>Adapun tujuan dari rekomendasi kebutuhan JFK diantaranya:</p>
<ul>
<li>Sebagai syarat pengusulan Uji Kompetensi</li>
<li>Sebagai syarat perubahan nomenklatur</li>
<li>Sebagai bagian pengangkatan dan pengembangan karier</li>
<li>Pengisian volume beban kerja berdasarkan indikator yang sudah ditetapkan</li>
<li>Rekomendasi yang diberikan sebanding dengan jumlah kebutuhan per jenjang, unit kerja penempatan, dan peta jabatan</li>
</ul>
HTML,
            ],
            [
                'nama' => 'Pengembangan Kompetensi JFK',
                'slug' => 'pengembangan-kompetensi',
                'judul' => 'Pengembangan Kompetensi Jabatan Fungsional Kepegawaian',
                'urutan' => 2,
                'konten' => <<<'HTML'
<p>Pengembangan Kompetensi bagi ASN diatur dalam UU No.5 Tahun 2014, Berdasarkan hal tersebut maka setiap ASN memiliki hak dan kesempatan yang sama dalam mengembangkan kompetensi. Pengembangan kompetensi untuk ASN dapat dilaksanakan melalui pendidikan dan pelatihan, seminar, kursus, dan penataran. Pengembangan kompetensi ASN selanjutnya diatur lebih lanjut melalui Peraturan Lembaga Administrasi Negara (PerLAN) Nomor 5 Tahun 2018 tentang Pengembangan Kompetensi Pegawai Aparatur Sipil Negara (ASN). Hal ini juga sejalan dengan Peraturan Lembaga Administrasi Negara Nomor 10 Tahun 2018 tentang Pengembangan Kompetensi Pegawai Negeri Sipil (PNS). Berdasarkan Peraturan LAN tersebut, pengembangan kompetensi melalui pelatihan terdiri atas pelatihan klasikal dan pelatihan non klasikal. Pelatihan klasikal merupakan proses pembelajaran tatap muka di dalam kelas dengan mengacu kurikulum. Pelatihan non klasikal merupakan proses praktik kerja dan / atau pembelajaran di luar kelas dan dilaksanakan melalui jalur pertukaran PNS dengan pegawai swasta; magang / praktik kerja; benchmarking atau study visit; pelatihan jarak jauh; coaching; mentoring; detasering; penugasan terkait program prioritas; e-learning; belajar mandiri/self-development; team building; dan jalur lain yang memenuhi ketentuan pelatihan non klasikal.</p>
<p>PerLAN Nomor 5 Tahun 2018 juga mengatur tentang kewajiban setiap ASN untuk melaksanakan pengembangan kompetensi paling sedikit 20 (dua puluh) jam pelajaran dalam periode 1 (satu) tahun. Perhitungan 1 (satu) jam pelajaran setara dengan 45 (empat puluh lima) menit pembelajaran. Sehingga setiap instansi Pemerintah wajib menyusun rencana pengembangan kompetensi tahunan melalui rencana kerja anggaran tahunan instansi. Tentunya hal ini yang mendasari PPK untuk menetapkan kebutuhan dan rencana pengembangan kompetensi, melaksanakan pengembangan kompetensi serta melaksanakan evaluasi pengembangan kompetensi pegawai ASN.</p>
<p>Pengembangan Kompetensi bagi pegawai jabatan fungsional kepegawaian sangat penting dilakukan untuk meningkatkan pemahaman dan wawasan seputar tugas-tugas jabatan fungsional kepegawaian, selain itu untuk melakukan update atau pembaharuan tentang keilmuan sumber daya manusia aparatur. </p>
HTML,
            ],
            [
                'nama' => 'Uji Kompetensi JFK',
                'slug' => 'uji-kompetensi',
                'judul' => 'Uji Kompetensi Jabatan Fungsional Kepegawaian',
                'urutan' => 3,
                'konten' => <<<'HTML'
<p>Badan Kepegawaian Negara (BKN) selaku instansi Pembina Jabatan Fungsional Kepegawaian (JFK) DAN Direktorat Jabatan Fungsional Manajemen Aparatur Sipil Negara (Direktorat JF MASN) selaku unit Pembina Jabatan Fungsional bidang Kepegawaian di BKN, menyelenggarakan uji kompetensi bagi PNS yang akan diangkat menjadi Pejabat Fungsional bidang Kepegawaian semua jenjang, melalui mekanisme perpindahan jabatan dari jabatan lain atau kenaikan jenjang jabatan.</p>
<p>Pelaksanaan Uji Kompetensi diselenggarakan oleh Badan Kepegawaian Negara 4 (empat) periode dalam 1 (satu) tahun :</p>
<p class="mb-0">1.	Periode I pada bulan Februari tahun berjalan, surat usulan dari instansi paling lambat diterima akhir Desember tahun sebelumnya; </p>
<p class="mb-0">2.	Periode II pada bulan April tahun berjalan, surat usulan dari instansi paling lambat diterima akhir Februari tahun berjalan;</p>
<p class="mb-0">3.	Periode III pada bulan Juli tahun berjalan, surat usulan dari instansi paling lambat diterima akhir Mei tahun berjalan; dan </p>
<p class="mb-0">4.	Periode IV pada bulan Oktober tahun berjalan, surat usulan dari instansi paling lambat diterima akhir Agustus tahun berjalan.</p>
<p>Penyelenggaraan Uji Kompetensi Jabatan Fungsional bidang Kepegawaian akan dilaksanakan dengan ketentuan, persyaratan dan jadwal sebagaimana Surat Edaran Deputi Pembinaan Manajemen Kepegawaian yang akan diumumkan disetiap periodenya.</p>
<p><a href="/dokumen/ukomoktober.pdf">Surat Deputi Pelaksanaan Uji Kompetensi Jabatan Fungsional Kepegawaian</a></p>
HTML,
            ],
            [
                'nama' => 'Perpindahan JF Audiwan',
                'slug' => 'perpindahan-audiwan',
                'judul' => 'Perpindahan Audiwan Ke Jabatan Fungsional Kepegawaian Lainnya',
                'urutan' => 4,
                'konten' => <<<'HTML'
<p>Berdasarkan Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 94 Tahun 2020 tentang Jabatan Fungsional Auditor Manajemen Aparatur Sipil Negara, ditentukan bahwa Auditor Kepegawaian berubah menjadi Auditor Manajemen Aparatur Sipil Negara (Auditor Manajemen ASN) dan berkedudukan sebagai pelaksana teknis di bidang Audit Manajemen ASN pada Badan Kepegawaian Negara (tertutup). Kemudian dalam Surat Kepala Badan Kepegawaian Negara Nomor: 3475/B-BJ.02.02/SD/K/2021 tanggal 16 April 2021 tentang Pembinaan Jabatan Fungsional Auditor Kepegawaian diatur bahwa Auditor Kepegawaian di luar Badan Kepegawaian Negara mengajukan perpindahan ke Jabatan Fungsional Kepegawaian lain atau Jabatan Fungsional lainnya. Untuk kelancaran pelaksanaan perpindahan Jabatan Fungsional Auditor Kepegawaian ke dalam Jabatan Fungsional lainnya, perlu diterbitkan Surat Edaran Kepala Badan Kepegawaian Negara tentang Tata Cara Perpindahan Jabatan Fungsional Auditor Kepegawaian Ke Dalam Jabatan Fungsional Lainnya.</p>
<p>Hal ini sesuai dengan <a href="/dokumen/sebknno132022.pdf">Surat Edaran Kepala BKN Nomor 13 Tahun 2022</a></p>
<p>Adapun point-point perpindahan Jabatan Fungsional Audiwan ke Jabatan Fungsional lain diantaranya:</p>
<ul>
<li>Perubahan Auditor Kepegawaian ke Auditor Manajemen ASN yang bersifat tertutup</li>
<li>Jenis: Perpindahan ke JFK lain &amp; Perpindahan ke JF lain non JFK</li>
<li>Bagi ke JFK: Jenjang dan Angka Kredit sesuai dengan sebelumnya</li>
<li>Uji Kompetensi perpindahan ke JFK terakhir 28 September 2025</li>
<li>Pengangkatan ke JFK s.d 28 Desember 2025</li>
<li>Wajib pelaporan bagi perpindahan ke non JFK</li>
</ul>
HTML,
            ],
            [
                'nama' => 'Konversi Angka Kredit',
                'slug' => 'konversi-angka-kredit',
                'judul' => 'Konversi Angka Kredit Jabatan Fungsional Kepegawaian',
                'urutan' => 5,
                'konten' => <<<'HTML'
<p>Dengan dilaksanakannya perubahan nomenklatur Jabatan Fungsional kepegawaian dan akan dialihkannya nomenklatur Jabatan Fungsional Kepegawaian ke dalam nomenklatur Analis Sumber Daya Manusia Aparatur, Pranata Sumber Daya Manusia Aparatur, Asesor Sumber Daya Manusia Aparatur, serta Auditor Manajemen Aparatur Sipil Negara sehingga perlu dilakukan perubahan Angka Kredit. Untuk kelancaran pelaksanaan perubahan Angka Kredit tersebut, ditetapkan Surat Edaran tentang Petunjuk Teknis Pelaksanaan Perubahan Angka Kredit dan Penetapan Pengangkatan Perubahan Nomenklatur Jabatan Fungsional Kepegawaian dan untuk batas waktu penyampaian daftar usul penetapan angka kredit (DUPAK) sesuai dengan surat yang telah dibuat oleh Direktur Jabatan Fungsional Manajemen Aparatur Sipil Negara.</p>
<p>Hal ini dimuat dalam <a href="/dokumen/sebknno12thn2022.pdf">Surat Edaran Kepala BKN Nomor. 12 Tahun 2022</a> dan <a href="/dokumen/suratbataswaktu.pdf">Surat Batas Waktu Penyampaian Daftar Usul Penetapan Angka Kredit (DUPAK) Jabatan Fungsional Kepegawaian</a></p>
<p>Adapun point-point perubahan angka kredit dan penetapan pengangkatan perubahan nomenklatur jabatan fungsional kepegawaian diantaranya:</p>
<ul>
<li>Berdasarkan periode penilaian PAK terakhir</li>
<li>Periode penilaian PAK s.d 31 Desember 2021</li>
<li>Pengusulan Penilaian Angka Kredit s.d 30 Juni 2022 atau 31 Desember 2021</li>
<li>Penetapan Pengangkatan perubahan nomenklatur JFK s.d 31 Desember 2023</li>
<li>Batas waktu pengusulan penilaian Angka Kredit sebagai dasar konversi 30 November 2022</li>
</ul>
HTML,
            ],
            [
                'nama' => 'Pengusulan PAK',
                'slug' => 'pengusulan-pak',
                'judul' => 'Pengusulan Penetapan Angka Kredit (PAK)',
                'urutan' => 6,
                'konten' => <<<'HTML'
<p>Pengusulan penetapan angka kredit (PAK) adalah proses pengusulan penetapan angka kredit kepada pejabat yang berwenang menetapkan angka kredit. Angka Kredit adalah satuan nilai dari uraian kegiatan dan/atau akumulasi nilai dari uraian kegiatan yang harus dicapai oleh Pejabat Fungsional dalam rangka pembinaan karier yang bersangkutan.</p>
<p>Berikut alur proses pengajuan PAK:</p>
<div class="text-center">
<img src="/assets/img/alurpak.jpg" alt="Alur Pengusulan PAK" class="img-fluid">
</div>
HTML,
            ],
            [
                'nama' => 'Perubahan Nomenklatur',
                'slug' => 'perubahan-nomenklatur',
                'judul' => 'Perubahan Nomenklatur Jabatan Fungsional Kepegawaian',
                'urutan' => 7,
                'konten' => <<<'HTML'
<p>Dengan telah ditetapkannya Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 37 tahun 2020 tentang Jabatan Fungsional Analis Sumber Daya Manusia Aparatur, Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 38 tahun 2020 tentang Jabatan Fungsional Pranata Sumber Daya Manusia Aparatur, Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 39 tahun 2020 tentang Jabatan Fungsional Asesor Sumber Daya Manusia Aparatur, dan Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 94 tahun 2020 tentang Jabatan Fungsional Auditor Manajemen Aparatur Sipil Negara, untuk kelancaran pelaksanaan tugas jabatannya perlu diterbitkan Surat Edaran Kepala Badan Kepegawaian Negara tentang Perubahan Nomenklatur Jabatan Fungsional Kepegawaian.</p>

<p>Hal ini tercantum dalam <a href="/dokumen/sebknno11thn2022.pdf">Surat Edaran Kepala BKN Nomor. 11 Tahun 2022</a></p>

<p>Adapun point-point perubahan nomenklatur diantaranya:</p>
<ul>
<li>Ditetapkan dengan keputusan pengangkatan</li>
<li>Mencantumkan Angka Kredit Konversi</li>
<li>Masa Peralihan sampai dengan 31 Desember 2023</li>
<li>Pemberlakuan Kelas Jabatan Baru</li>
<li>Penetapan Tunjangan Jabatan Baru</li>
</ul>
HTML,
            ],
        ];

        $now = now();
        foreach ($halaman as $row) {
            DB::table('layanan_halamans')->insert($row + ['status' => true, 'created_at' => $now, 'updated_at' => $now]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('layanan_halamans');
    }
};
