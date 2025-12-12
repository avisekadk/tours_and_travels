<?php
// app/Models/Inquiry.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'type',
        'status',
        'admin_reply',
        'replied_by',
        'replied_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    // Relationships
    public function repliedByUser()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    // Scopes
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }
}