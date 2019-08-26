<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('artist')->nullable();
            $table->string('youtube_id')->nullable();
            $table->integer('video_start')->nullable();
            $table->integer('video_end')->nullable();
            $table->text('lyrics')->nullable();
            $table->string('spotify_id');
            $table->string('spotify_album_id');
            $table->string('spotify_artist_id');
            $table->string('spotify_uri');
            $table->string('spotify_href');
            $table->unsignedInteger('album_id');
            $table->unsignedInteger('artist_id');
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
        Schema::dropIfExists('records');
    }
}
