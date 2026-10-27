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
        Schema::create('organisasi_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('organisasi_units')->nullOnDelete();
            $table->string('nama');
            $table->string('jabatan');
            $table->string('unit')->nullable();
            $table->string('foto')->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('urutan')->default(0);
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
        Schema::dropIfExists('organisasi_units');
    }
};
