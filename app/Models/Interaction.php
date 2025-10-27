<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'contact_id', 
        'type', // Misalnya: 'call', 'email', 'meeting'
        'summary',
        'scheduled_at' // Waktu interaksi
    ];

    // Relasi: Interaction dimiliki oleh satu Contact (Many-to-One)
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    // Relasi: Interaction dimiliki oleh satu User (pembuat log)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}