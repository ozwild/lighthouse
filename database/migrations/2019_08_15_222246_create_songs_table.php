<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('artist')->nullable();
            $table->string('key')->nullable();
            $table->string('youtube_id')->nullable();
            $table->integer('video_start')->nullable();
            $table->integer('video_end')->nullable();
            $table->text('lyrics')->nullable();
            $table->string('spotify_id')->nullable();
            $table->string('spotify_album_id')->nullable();
            $table->string('spotify_artist_id')->nullable();
            $table->string('spotify_uri')->nullable();
            $table->string('spotify_href')->nullable();
            $table->unsignedInteger('album_id')->nullable();
            $table->unsignedInteger('artist_id')->nullable();
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
        Schema::dropIfExists('songs');
    }
}
