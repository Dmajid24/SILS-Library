<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Information extends Model
{
    use HasUuids;
    protected $fillable = [
        'school_id',
        'creator_id',
        'title',
        'content',
        'image_content',
        'description'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function school()
    {
        return $this->belongsTo(school::class);
    }
}
