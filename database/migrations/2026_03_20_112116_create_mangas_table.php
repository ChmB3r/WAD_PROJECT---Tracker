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
        Schema::create('mangas', function (Blueprint $table) {
            $table->id();
            $table->integer('mal_id')->nullable();
            $table->string('title');
            $table->string('type')->nullable();
            $table->enum('status', ['Plan to read', 'Reading', 'On-hold', 'Completed', 'Dropped'])->default('Plan to read');
            $table->string('image_url')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mangas');
    }
};
