<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'school_id',
        'nim',
        'major',
        'faculty'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}