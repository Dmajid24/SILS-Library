<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StaffProfile;

class StaffProfileSeeder extends Seeder
{
    public function run(): void
    {
        $staff = User::where('role','staff')->get();

        StaffProfile::create([
            'user_id' => $staff[0]->id,
            'school_id'=> $staff[0]->school_id,
            'employee_id' => 'EMP001',
            'job_position' => 'Administration',
            'department' => 'Academic Office'
        ]);
         StaffProfile::create([
            'user_id' => $staff[1]->id,
            'school_id'=> $staff[1]->school_id,
            'employee_id' => 'EMP002',
            'job_position' => 'Administration',
            'department' => 'Academic Office'
        ]);
    }
}
