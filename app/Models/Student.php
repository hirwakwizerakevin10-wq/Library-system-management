<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'full_name', 'registration_number', 'email', 'phone', 'department'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function borrows(): HasMany
    {
        return $this->hasMany(Borrow::class);
    }

    public function lostBooks(): HasMany
    {
        return $this->hasMany(LostBook::class);
    }
}
