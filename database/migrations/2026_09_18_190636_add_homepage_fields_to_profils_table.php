<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profils', function (Blueprint $table) {
            $table->string('hero_judul')->nullable()->after('id');
            $table->text('hero_deskripsi')->nullable()->after('hero_judul');
            $table->string('about_judul')->nullable()->after('hero_deskripsi');
            $table->string('stat_label_organisasi')->nullable()->after('about_judul');
            $table->string('stat_label_layanan')->nullable()->after('stat_label_organisasi');
            $table->string('stat_label_kegiatan')->nullable()->after('stat_label_layanan');
            $table->string('stat_label_publikasi')->nullable()->after('stat_label_kegiatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profils', function (Blueprint $table) {
            $table->dropColumn([
                'hero_judul',
                'hero_deskripsi',
                'about_judul',
                'stat_label_organisasi',
                'stat_label_layanan',
                'stat_label_kegiatan',
                'stat_label_publikasi',
            ]);
        });
    }
};
