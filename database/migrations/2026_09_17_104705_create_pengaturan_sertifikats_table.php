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
        Schema::create('pengaturan_sertifikats', function (Blueprint $table) {
            $table->id();
            $table->string('prefix')->default('SERT');
            $table->unsignedTinyInteger('digit_urut')->default(5);
            $table->boolean('reset_tahunan')->default(true);
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
        Schema::dropIfExists('pengaturan_sertifikats');
    }
};
