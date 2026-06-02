<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'student_id', 'borrow_date', 'due_date', 'return_date', 'status', 'notes'];

    protected $casts = [
        'borrow_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function lostBook(): HasOne
    {
        return $this->hasOne(LostBook::class);
    }
}
