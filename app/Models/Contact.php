<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'company_id', 
        'first_name', 
        'last_name', 
        'email', 
        'phone_number', 
        'job_title', 
        'city', 
        'is_customer', 
        'notes'
    ];

     public function scopeOwnedBy(Builder $query, $user)
    {
        // Jika user memiliki role 'admin', kembalikan query tanpa filter (melihat semua)
        if ($user->hasRole('admin')) {
            return $query;
        }
        
        // Jika user adalah user biasa, filter berdasarkan user_id mereka
        return $query->where('user_id', $user->id);
    }

    // Relasi: Contact dimiliki oleh satu Company (Many-to-One)
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    // Relasi: Contact dimiliki oleh satu User (pembuat data)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Contact memiliki banyak Interactions (Log Aktivitas)
    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class);
    }
}