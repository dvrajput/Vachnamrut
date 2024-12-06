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
        // Drop the 'song_playlist_rels' table if it exists
        Schema::dropIfExists('song_playlist_rels');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
