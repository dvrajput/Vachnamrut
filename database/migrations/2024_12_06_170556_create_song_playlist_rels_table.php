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
        Schema::create('song_playlist_rels', function (Blueprint $table) {
            // Add an auto-incrementing primary key `id`
            $table->id(); // This creates the auto-incrementing `id` column as the primary key

            // Foreign key for the song_code
            $table->string('song_code');
            $table->foreign('song_code')
                ->references('song_code') // Assuming the `songs` table has a `song_code` column
                ->on('songs')
                ->onDelete('cascade'); // Ensures deletion of the relation when the song is deleted

            // Foreign key for the playlist_code
            $table->string('playlist_code');
            $table->foreign('playlist_code')
                ->references('playlist_code') // Assuming the `playlists` table has a `playlist_code` column
                ->on('playlists')
                ->onDelete('cascade'); // Ensures deletion of the relation when the playlist is deleted

            // Optional: Add timestamps if you want to track creation and updates
            //$table->timestamps(); // Automatically adds `created_at` and `updated_at` fields

            // Create a unique constraint instead of a composite primary key
            $table->unique(['song_code', 'playlist_code']); // Ensure the combination of these two columns is unique
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('song_playlist_rels');
    }
};
