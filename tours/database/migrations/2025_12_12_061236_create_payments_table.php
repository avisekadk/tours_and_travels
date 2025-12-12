<?php
// database/migrations/create_payments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['esewa', 'khalti', 'paypal', 'stripe', 'bank_transfer', 'cash'])->default('esewa');
            $table->string('transaction_id')->unique()->nullable();
            $table->json('gateway_response')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->enum('status', ['pending', 'success', 'failed', 'refunded'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('booking_id');
            $table->index('transaction_id');
            $table->index('payment_method');
            $table->index('status');
            $table->index('payment_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};