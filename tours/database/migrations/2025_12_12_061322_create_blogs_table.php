<?php
// database/migrations/create_blogs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->text('excerpt')->nullable();
            $table->string('featured_image')->nullable();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->json('tags')->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->integer('reading_time')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('slug');
            $table->index('author_id');
            $table->index('category_id');
            $table->index('status');
            $table->index('published_at');
            $table->index('views');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};