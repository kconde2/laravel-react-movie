<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tmdb_id')->unique();
            $table->string('title');
            $table->string('original_title');
            $table->text('overview');
            $table->string('poster_path');
            $table->string('media_type');
            $table->string('backdrop_path');
            $table->boolean('is_adult');
            $table->string('original_language');
            $table->float('popularity');
            $table->date('release_date')->nullable();
            $table->boolean('is_video');
            $table->float('vote_average');
            $table->integer('vote_count');
            $table->json('time_windows');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
