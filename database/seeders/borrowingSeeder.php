<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\borrowings;
use App\Models\User;
use App\Models\Book;
use App\Models\school;

use Carbon\Carbon;

class BorrowingSeeder extends Seeder
{
    public function run(): void
    {
        $student = User::where('role','student')->first();
        $book = Book::first();
        $school = school::all();

        borrowings::create([
            'school_id'=>$school[0]->id,
            'borrower_id' => $student->id,
            'book_id' => $book->id,
            'request_date' => Carbon::now(),
            'borrow_date' => Carbon::now(),
            'due_date' => Carbon::now()->addDays(7),
            'status' => 'borrowed'
        ]);
    }
}
