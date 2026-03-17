<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\school;
class BookSeeder extends Seeder
{
    public function run(): void
    {
        $schools = school::all();
        Book::create([
            'school_id'=>$schools[0]->id,
            'isbn' => '9786021234567',
            'title' => 'Introduction to Algorithms',
            'description' => 'Algorithm fundamentals',
            'page' => 900,
            'author' => 'Thomas H. Cormen',
            'publisher' => 'MIT Press',
            'stock' => 5
        ]);

        Book::create([
            'school_id'=>$schools[0]->id,
            'isbn' => '9780131103627',
            'title' => 'The C Programming Language',
            'description' => 'Classic programming book',
            'page' => 300,
            'author' => 'Dennis Ritchie',
            'publisher' => 'Prentice Hall',
            'stock' => 3,
            'cover'=> null
        ]);

        Book::create([
            'school_id'=>$schools[1]->id,
            'isbn' => '9780131103627',
            'title' => 'The C Programming Language',
            'description' => 'Classic programming book',
            'page' => 300,
            'author' => 'Dennis Ritchie',
            'publisher' => 'Prentice Hall',
            'stock' => 3,
            'cover' => null
        ]);
    }
}