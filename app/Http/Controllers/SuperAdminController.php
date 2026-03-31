<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Book;
use App\Http\Models\School;
use App\Http\Models\User;



class SuperAdminController extends Controller
{
    public function index()
    {
        // Proteksi role
        if (auth()->user()->role !== 'super_admin') {
            abort(403);
        }

        
            $totalSchools = School::count();
            $totalUsers = User::count();
            $totalBooks = Book::count();
            // 'totalBorrowings' => Borrowing::count(),
            // 'activeBorrowings' => Borrowing::where('status', 'borrowed')->count(),
        

        return view('superAdmin.dashboard',compact('totalSchools','totalUsers','totalBooks'));
    }
    
}
