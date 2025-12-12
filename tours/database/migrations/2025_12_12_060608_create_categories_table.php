<?php
// database/migrations/create_categories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            
            // Indexes
            $table->index('slug');
            $table->index('status');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};