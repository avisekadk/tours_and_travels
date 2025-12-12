<?php
// database/migrations/create_destinations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->string('image')->nullable();
            $table->string('banner_image')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('status')->default(true);
            $table->string('weather_city')->nullable();
            $table->string('best_season')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('slug');
            $table->index('featured');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};