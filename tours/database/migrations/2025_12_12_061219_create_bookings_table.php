<?php
// database/migrations/create_bookings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tour_id')->constrained()->restrictOnDelete();
            $table->date('booking_date');
            $table->date('travel_date');
            $table->date('return_date')->nullable();
            $table->integer('number_of_people')->default(1);
            $table->decimal('tour_price', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->string('discount_code')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->enum('booking_status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->text('special_requests')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('booking_number');
            $table->index('user_id');
            $table->index('tour_id');
            $table->index('payment_status');
            $table->index('booking_status');
            $table->index('travel_date');
            $table->index('booking_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};