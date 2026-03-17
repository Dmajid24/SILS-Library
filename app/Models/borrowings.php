<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class borrowings extends Model
{
    use HasFactory;
    use HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';

      protected $fillable = [
        'school_id',
        'borrower_id',
        'book_id',
        'request_date',
        'borrow_date',
        'due_date',
        'return_date',
        'status'
    ];

    protected $casts = [
    'request_date' => 'datetime',
    'borrow_date' => 'datetime',
    'due_date' => 'datetime',
    'return_date' => 'datetime',
];

    public function user()
    {
        return $this->belongsTo(User::class, 'borrower_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
