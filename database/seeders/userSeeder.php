<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\school;
class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        $school = school::all();
        
        User::create([
            'school_id'=> $school[0]->id,
            'first_name' => 'Admin',
            'last_name' => 'Library',
            'role' => 'admin',
            'email' => 'admin1@mail.com',
            'phone' => '0811111111',
            'password' => Hash::make('password'),
        ]);

        // STUDENT
        User::create([
            'school_id'=> $school[0]->id,
            'first_name' => 'Budi',
            'last_name' => 'Santoso',
            'role' => 'student',
            'email' => 'student1@mail.com',
            'phone' => '0822222222',
            'password' => Hash::make('password'),
        ]);

        // LECTURER
        User::create([
            'school_id'=> $school[0]->id,
            'first_name' => 'Dr',
            'last_name' => 'Andi',
            'role' => 'lecturer',
            'email' => 'lecturer1@mail.com',
            'phone' => '0833333333',
            'password' => Hash::make('password'),
        ]);

        // STAFF
        User::create([
            'school_id'=> $school[0]->id,
            'first_name' => 'Siti',
            'last_name' => 'Rahma',
            'role' => 'staff',
            'email' => 'staff1@mail.com',
            'phone' => '0844444444',
            'password' => Hash::make('password'),
        ]);

         User::create([
            'school_id'=> $school[1]->id,
            'first_name' => 'Admin',
            'last_name' => 'Library',
            'role' => 'admin',
            'email' => 'admin@mail.com',
            'phone' => '0811111111',
            'password' => Hash::make('password'),
        ]);

        // STUDENT
        User::create([
            'school_id'=> $school[1]->id,
            'first_name' => 'Budi',
            'last_name' => 'Santoso',
            'role' => 'student',
            'email' => 'student@mail.com',
            'phone' => '0822222222',
            'password' => Hash::make('password'),
        ]);

        // LECTURER
        User::create([
            'school_id'=> $school[1]->id,
            'first_name' => 'Dr',
            'last_name' => 'Andi',
            'role' => 'lecturer',
            'email' => 'lecturer@mail.com',
            'phone' => '0833333333',
            'password' => Hash::make('password'),
        ]);

        // STAFF
        User::create([
            'school_id'=> $school[1]->id,
            'first_name' => 'Siti',
            'last_name' => 'Rahma',
            'role' => 'staff',
            'email' => 'staff@mail.com',
            'phone' => '0844444444',
            'password' => Hash::make('password'),
        ]);
    }
}
