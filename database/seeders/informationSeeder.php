<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Information;
use App\Models\User;
use App\Models\school;

class informationSeeder extends Seeder
{
    public function run(): void
    {   
        $school = school::all();

        $admin = User::where('role','admin')->get();


        
        Information::create([
            'creator_id' => $admin[0]->id,
            'school_id'=>$school[0]->id,
            'title' => 'Library Opening',
            'description' => 'Library open from 08:00 - 17:00',
            'image_content' => null
        ]);
         Information::create([
            'creator_id' => $admin[1]->id,
            'school_id'=>$school[1]->id,
            'title' => 'Library Opening',
            'description' => 'Library open from 08:00 - 17:00',
            'image_content' => null
        ]);
    }
}
