<?php
// database/migrations/create_tour_images_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->string('image_path');
            $table->string('thumbnail_path')->nullable();
            $table->string('caption')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            // Indexes
            $table->index('tour_id');
            $table->index('is_featured');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_images');
    }
};