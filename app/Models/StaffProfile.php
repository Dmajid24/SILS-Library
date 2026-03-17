<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffProfile extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'employee_id',
        'job_position',
        'department'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
