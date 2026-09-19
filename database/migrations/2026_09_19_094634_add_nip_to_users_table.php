<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom NIP dipakai untuk menautkan akun admin lokal ke identitas SIASN,
     * supaya pemiliknya bisa login pakai SSO SIASN (NIP + password SIASN)
     * selain login email/password biasa. Nullable karena tidak semua admin
     * wajib punya NIP tertaut.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nip')->nullable()->unique()->after('username');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nip');
        });
    }
};
