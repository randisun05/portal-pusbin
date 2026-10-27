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
        Schema::table('organisasi_units', function (Blueprint $table) {
            $table->string('email')->nullable()->after('deskripsi');
            $table->string('telepon')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organisasi_units', function (Blueprint $table) {
            $table->dropColumn(['email', 'telepon']);
        });
    }
};
