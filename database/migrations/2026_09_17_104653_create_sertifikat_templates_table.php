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
        Schema::create('sertifikat_templates', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('warna_aksen')->default('#f92c24');
            $table->string('logo')->nullable();
            $table->string('teks_pembuka')->default('Diberikan kepada:');
            $table->text('teks_keterangan')->default('NIP {nip}, {jabatan} dari {instansi}, atas partisipasinya dalam kegiatan {kegiatan} yang diselenggarakan pada {waktu}.');
            $table->string('nama_penandatangan')->nullable();
            $table->string('jabatan_penandatangan')->nullable();
            $table->string('tanda_tangan')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sertifikat_templates');
    }
};
