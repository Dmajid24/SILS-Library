<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class book extends Model
{
    use HasFactory;
    use HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];
    protected $fillable = [
        'school_id',
        'isbn',
        'title',
        'description',
        'page',
        'author',
        'publisher',
        'stock',
        'cover'
    ];

    public function school()
    {
        return $this->belongsTo(school::class);
    }

    public function borrowings()
    {
        return $this->hasMany(borrowings::class);
    }
    public function reviews(){
        return $this->hasMany(Review::class);
    }
}