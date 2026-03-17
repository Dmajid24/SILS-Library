<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            SchoolSeeder::class,
            UserSeeder::class,
            StudentProfileSeeder::class,
            LecturerProfileSeeder::class,
            StaffProfileSeeder::class,
            BookSeeder::class,
            InformationSeeder::class,
            BorrowingSeeder::class,
        ]);
    }
}
