<?php
// database/migrations/create_favorites_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes & Constraints
            $table->index('user_id');
            $table->index('tour_id');
            $table->unique(['user_id', 'tour_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};