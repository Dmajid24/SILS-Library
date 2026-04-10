<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StudentProfile;

class StudentProfileSeeder extends Seeder
{
    public function run(): void
    {
        $student = User::where('role','student')->get();

        StudentProfile::create([
            'user_id' => $student[0]->id,
            'school_id'=> $student[0]->school_id,
            'nim' => '2601234567',
            'major' => 'Computer Science',
            'faculty' => 'School of Computer Science'
        ]);
    }
}
