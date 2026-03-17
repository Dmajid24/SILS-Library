<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class school extends Model
{
    use HasUuids;
    protected $fillable = [
        'name',
        'logo',
        'address',
        'phone',
        'email',
        'description'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function books()
    {
        return $this->hasMany(book::class);
    }

    public function informations()
    {
        return $this->hasMany(information::class);
    }
}