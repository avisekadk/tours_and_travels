<?php
// database/migrations/create_inquiries_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject');
            $table->text('message');
            $table->enum('type', ['general', 'booking', 'complaint', 'suggestion'])->default('general');
            $table->enum('status', ['new', 'in_progress', 'replied', 'closed'])->default('new');
            $table->text('admin_reply')->nullable();
            $table->foreignId('replied_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('replied_at')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('type');
            $table->index('email');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};