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
        Schema::create('konsultasis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nip');
            $table->foreignId('kode_id');
            $table->timestamp('jadwal');
            $table->timestamp('jadwalfix')->nullable();
            $table->string('link')->nullable();
            $table->string('pic')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('tiket')->nullable();
            $table->boolean('jawab')->default(0);
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
        Schema::dropIfExists('konsultasis');
    }
};
