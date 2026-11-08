<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('layanan_halamans', 'icon')) {
            Schema::table('layanan_halamans', function (Blueprint $table) {
                $table->dropColumn('icon');
            });
        }
    }

    public function down()
    {
        //
    }
};
