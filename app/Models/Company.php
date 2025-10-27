<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Company extends Model
{
    use HasFactory;
    
    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'user_id', 
        'name', 
        'website', 
        'phone_number', 
        'address', 
        'industry', 
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

    // Relasi: Company dimiliki oleh satu User (pembuat data)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    // Relasi: Company memiliki banyak Contacts (One-to-Many)
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}