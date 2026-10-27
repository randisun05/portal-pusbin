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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->string('nama');
            $table->string('email')->nullable();
            $table->text('body');
            $table->boolean('approved')->default(false);
            $table->timestamps();
        });

        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->string('session_id');
            $table->string('type');
            $table->timestamps();
            $table->unique(['post_id', 'session_id']);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('views')->default(0)->after('body');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('views');
        });

        Schema::dropIfExists('reactions');
        Schema::dropIfExists('comments');
    }
};
