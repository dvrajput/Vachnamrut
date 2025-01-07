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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('song_code')->nullable();
            $table->foreign('song_code')
                ->references('song_code')
                ->on('songs')
                ->onDelete('cascade');
            $table->text('message');
            $table->tinyInteger('status')->default(0)->comment('0-pending,1-approve,2-reject');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
