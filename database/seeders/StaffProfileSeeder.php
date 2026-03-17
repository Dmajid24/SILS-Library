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
        $staff = User::where('role','staff')->first();

        StaffProfile::create([
            'user_id' => $staff->id,
            'employee_id' => 'EMP001',
            'job_position' => 'Administration',
            'department' => 'Academic Office'
        ]);
    }
}
