<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LostBook extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'student_id', 'borrow_id', 'quantity', 'lost_date', 'notes'];

    protected $casts = ['lost_date' => 'date'];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function borrow(): BelongsTo
    {
        return $this->belongsTo(Borrow::class);
    }
}
