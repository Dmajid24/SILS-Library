<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LecturerProfile extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'nip',
        'degree',
        'department'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}