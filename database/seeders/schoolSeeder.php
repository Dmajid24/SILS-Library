<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        School::create([
            'name' => 'Binus University',
            'address' => 'Jakarta, Indonesia',
            'phone' => '021123456',
            'email' => 'info@binus.edu',
            'description' => 'Smart Campus Library',
            'logo' => 'logo.png'
        ]);

        school::create([
            'name' => 'Telkom University',
            'address' => 'Jakarta, Indonesia',
            'phone' => '082123456789',
            'email' => 'telkom@email.co.id',
            'description' => 'Smart Campus Library',
            'logo' => 'logo.png'
        ]);
    }
}
