<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('highlights', function (Blueprint $table) {
            $table->string('group')->default('fungsi')->after('id');
            $table->string('icon')->nullable()->after('desc');
            $table->string('link')->nullable()->after('icon');
            $table->unsignedInteger('urutan')->default(0)->after('link');
            $table->string('image')->nullable()->change();
        });

        // Data existing sebelum kolom "group" ditambahkan adalah data lama
        // (jika ada) yang tidak terhubung ke bagian manapun di beranda saat
        // ini, jadi diberi grup "fungsi" secara default lewat kolom baru.

        // Seed konten default 3 bagian beranda yang sebelumnya hardcoded di
        // Blade, supaya tampilan tidak berubah begitu migration ini jalan.
        if (DB::table('highlights')->count() === 0) {
            $now = now();

            DB::table('highlights')->insert([
                // Hero: 3 kotak alasan
                ['group' => 'hero', 'name' => 'Uji Kompetensi', 'desc' => 'Dilaksanakan 4 periode dalam setahun secara daring, tanpa dipungut biaya.', 'icon' => 'bi-clipboard-data', 'link' => null, 'image' => null, 'urutan' => 0, 'created_at' => $now, 'updated_at' => $now],
                ['group' => 'hero', 'name' => 'Konsultasi Online', 'desc' => 'Ajukan pertanyaan seputar jabatan fungsional dan dapatkan nomor tiket jawaban.', 'icon' => 'bi-headset', 'link' => null, 'image' => null, 'urutan' => 1, 'created_at' => $now, 'updated_at' => $now],
                ['group' => 'hero', 'name' => 'Sertifikat Digital', 'desc' => 'Unduh sertifikat kegiatan langsung, lengkap dengan QR verifikasi keaslian.', 'icon' => 'bi-patch-check', 'link' => null, 'image' => null, 'urutan' => 2, 'created_at' => $now, 'updated_at' => $now],

                // About: 3 poin
                ['group' => 'about', 'name' => 'Dilaksanakan 4 Periode Dalam 1 Tahun', 'desc' => 'Jadwal ujikom terbuka setiap periode dan dapat diikuti sesuai jenjang jabatan fungsional.', 'icon' => 'bi-calendar-check', 'link' => null, 'image' => null, 'urutan' => 0, 'created_at' => $now, 'updated_at' => $now],
                ['group' => 'about', 'name' => 'Dilaksanakan Secara Full Daring', 'desc' => 'Peserta dapat mengikuti seluruh proses tanpa perlu hadir secara fisik.', 'icon' => 'bi-laptop', 'link' => null, 'image' => null, 'urutan' => 1, 'created_at' => $now, 'updated_at' => $now],
                ['group' => 'about', 'name' => 'Tidak Dipungut Biaya', 'desc' => 'Seluruh layanan Direktorat JF MASN diberikan tanpa biaya kepada peserta.', 'icon' => 'bi-cash-coin', 'link' => null, 'image' => null, 'urutan' => 2, 'created_at' => $now, 'updated_at' => $now],

                // Fungsi & Layanan Interaktif: 4 kartu
                ['group' => 'fungsi', 'name' => 'Survei Kepuasan', 'desc' => 'Berikan penilaian Anda atas layanan kami dan ikuti survei yang sedang berjalan.', 'icon' => 'bi-clipboard2-pulse', 'link' => '/survei', 'image' => null, 'urutan' => 0, 'created_at' => $now, 'updated_at' => $now],
                ['group' => 'fungsi', 'name' => 'Konsultasi Online', 'desc' => 'Ajukan pertanyaan seputar jabatan fungsional dan pantau jawabannya lewat nomor tiket.', 'icon' => 'bi-headset', 'link' => '/konsultasi', 'image' => null, 'urutan' => 1, 'created_at' => $now, 'updated_at' => $now],
                ['group' => 'fungsi', 'name' => 'Repository JF MASN', 'desc' => 'Cari peraturan, surat edaran, dan dokumen rujukan jabatan fungsional kepegawaian.', 'icon' => 'bi-journal-text', 'link' => '/repository', 'image' => null, 'urutan' => 2, 'created_at' => $now, 'updated_at' => $now],
                ['group' => 'fungsi', 'name' => 'Verifikasi Sertifikat', 'desc' => 'Periksa keaslian sertifikat kegiatan menggunakan nomor sertifikat atau kode QR.', 'icon' => 'bi-patch-check', 'link' => '/verifikasi-sertifikat', 'image' => null, 'urutan' => 3, 'created_at' => $now, 'updated_at' => $now],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('highlights', function (Blueprint $table) {
            $table->dropColumn(['group', 'icon', 'link', 'urutan']);
        });
    }
};
