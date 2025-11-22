<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number',
        'user_id',
        'tour_id',
        'booking_date',
        'travel_date',
        'return_date',
        'number_of_people',
        'tour_price',
        'discount_amount',
        'total_amount',
        'discount_code',
        'payment_status',
        'booking_status',
        'special_requests',
        'cancellation_reason',
        'confirmed_at',
        'completed_at',
        'cancelled_at',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'travel_date' => 'date',
        'return_date' => 'date',
        'number_of_people' => 'integer',
        'tour_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    // Automatically generate booking number
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($booking) {
            if (empty($booking->booking_number)) {
                $booking->booking_number = 'BK-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
            }
            if (empty($booking->booking_date)) {
                $booking->booking_date = now();
            }
        });
    }

    // Belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Belongs to tour
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    // Has one payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('booking_status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('booking_status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('booking_status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('booking_status', 'cancelled');
    }

    // Check if booking is paid
    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    // Check if booking is confirmed
    public function isConfirmed()
    {
        return $this->booking_status === 'confirmed';
    }
}