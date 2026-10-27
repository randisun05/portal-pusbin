<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('formulir_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formulir_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->string('tipe');
            $table->json('opsi')->nullable();
            $table->boolean('wajib')->default(false);
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('formulir_fields');
    }
};
