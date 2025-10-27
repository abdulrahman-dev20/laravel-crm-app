<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'contact_id', 
        'title',
        'description',
        'due_date',
        'is_completed',
    ];

    protected $casts = [
        'is_completed' => 'boolean', // Konversi 0/1 di DB menjadi true/false di PHP
        'due_date' => 'date',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}