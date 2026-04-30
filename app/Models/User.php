<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Notifications\CustomResetPasswordNotification;

class User extends Authenticatable
{
    use HasFactory, HasUuids ,Notifiable;


    public $incrementing = false;
    protected $keyType = 'string';

   protected $fillable = [
        'school_id',
        'first_name',
        'last_name',
        'role',
        'email',
        'phone',
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    // ================= RELATIONS =================

    public function school()
    {
        return $this->belongsTo(school::class);
    }

    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function lectureProfile()
    {
        return $this->hasOne(LecturerProfile::class);
    }

    public function staffProfile()
    {
        return $this->hasOne(StaffProfile::class);
    }

    public function borrowings()
    {
        return $this->hasMany(borrowings::class, 'borrower_id');
    }

    public function informations()
    {
        return $this->hasMany(information::class, 'creator_id');
    }
    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }
}