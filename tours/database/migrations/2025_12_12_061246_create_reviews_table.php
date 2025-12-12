<?php
// database/migrations/create_reviews_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('rating');
            $table->string('title')->nullable();
            $table->text('comment');
            $table->json('images')->nullable();
            $table->boolean('approved')->default(false);
            $table->text('admin_reply')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('tour_id');
            $table->index('approved');
            $table->index('rating');
            
            // Unique constraint
            $table->unique(['user_id', 'tour_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};