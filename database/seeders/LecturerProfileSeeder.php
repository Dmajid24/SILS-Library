<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\LecturerProfile;

class LecturerProfileSeeder extends Seeder
{
    public function run(): void
    {
        $lecturer = User::where('role','lecturer')->get();

        LecturerProfile::create([
            'user_id' => $lecturer[0]->id,
            'nip' => '1987654321',
            'degree' => 'Ph.D',
            'department' => 'Computer Science'
        ]);

        LecturerProfile::create([
            'user_id' => $lecturer[1]->id,
            'nip' => '17853233521',
            'degree' => 'M.kom',
            'department' => 'System Information'
        ]);
    }
}   
