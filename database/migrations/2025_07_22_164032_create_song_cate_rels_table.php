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
        Schema::create('song_cate_rels', function (Blueprint $table) {
            $table->id();

            // Foreign key for the song_code
            $table->string('song_code');
            $table->foreign('song_code')
                ->references('song_code')
                ->on('songs')
                ->onDelete('cascade');

            // Foreign key for the category_code
            $table->string('category_code');
            $table->foreign('category_code')
                ->references('category_code')
                ->on('categories')
                ->onDelete('cascade');

            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('song_cate_rels');
    }
};
