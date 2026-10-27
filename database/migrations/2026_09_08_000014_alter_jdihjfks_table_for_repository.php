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
        Schema::table('jdihjfks', function (Blueprint $table) {
            $table->string('status')->default('published')->after('image');
            $table->text('deskripsi')->change();
            $table->string('link')->nullable()->change();
            $table->string('image')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jdihjfks', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->string('deskripsi')->change();
            $table->string('link')->nullable(false)->change();
            $table->string('image')->nullable(false)->change();
        });
    }
};
