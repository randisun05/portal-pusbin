<?php

use App\Models\Post;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Post::body dulu disimpan mentah tanpa sanitasi (lihat model Post,
     * setBodyAttribute ditambahkan belakangan). Migration ini menjalankan
     * ulang sanitasi HTML untuk semua post yang sudah ada, supaya konten
     * lama pun ikut bersih dari tag/atribut berbahaya kalau ada.
     *
     * @return void
     */
    public function up()
    {
        Post::cursor()->each(function (Post $post) {
            $post->body = $post->body;
            $post->saveQuietly();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
