<?php
// database/migrations/create_tours_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->text('short_description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('price_type')->default('per_person');
            $table->integer('duration');
            $table->string('duration_type')->default('days');
            $table->enum('difficulty', ['easy', 'moderate', 'challenging', 'difficult'])->default('moderate');
            $table->integer('max_people')->nullable();
            $table->integer('min_people')->default(1);
            $table->string('location')->nullable();
            $table->string('featured_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->json('itinerary')->nullable();
            $table->json('inclusions')->nullable();
            $table->json('exclusions')->nullable();
            $table->json('highlights')->nullable();
            $table->json('important_notes')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('destination_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['draft', 'published', 'archived'])->default('published');
            $table->unsignedBigInteger('views')->default(0);
            $table->boolean('featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->string('video_url')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('slug');
            $table->index('category_id');
            $table->index('destination_id');
            $table->index('status');
            $table->index('featured');
            $table->index('price');
            $table->index('difficulty');
            $table->index('views');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};