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
        Schema::create('sertifikats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absensi_id')->constrained('absensis')->cascadeOnDelete();
            $table->string('nomor_sertifikat')->unique();
            $table->string('status')->default('diterbitkan'); // diterbitkan, terkirim, gagal_kirim
            $table->timestamp('sent_at')->nullable();
            $table->text('sent_response')->nullable();
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
        Schema::dropIfExists('sertifikats');
    }
};
