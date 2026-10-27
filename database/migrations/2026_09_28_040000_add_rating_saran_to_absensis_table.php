<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Langkah kepuasan singkat (rating emoji + saran opsional) yang
     * ditambahkan ke alur absensi kegiatan - nullable supaya data absensi
     * lama tetap valid dan alur lama (mis. "Rencana Hadir" dari
     * PublicKegiatanController) yang tidak mengisi field ini tetap jalan.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->unsignedTinyInteger('rating')->nullable()->after('instansi');
            $table->text('saran')->nullable()->after('rating');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropColumn(['rating', 'saran']);
        });
    }
};
