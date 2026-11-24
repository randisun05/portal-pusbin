<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->string('myasn_riwayat_id')->nullable();
            $table->string('myasn_orang_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->dropColumn(['myasn_riwayat_id', 'myasn_orang_id']);
        });
    }
};
