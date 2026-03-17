<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\book;
use App\Models\User;
use App\Models\information;
use App\Models\borrowings;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // ADMIN DASHBOARD
        if ($user->role === 'admin') {

            $booksCount = Book::where('school_id',$user->school_id)->count();

            $borrowedCount = Borrowings::where('school_id',$user->school_id)
                ->where('status','borrowed')
                ->count();

            $pending = Borrowings::where('school_id',$user->school_id)
                ->where('status','requested')
                ->count();

            $usersCount = User::where('school_id',$user->school_id)->count();

            
            $status = request('status');

            $borrowings = Borrowings::with(['book','user'])
                ->where('school_id',$user->school_id)
                ->when($status, function($q) use ($status){
                    $q->where('status',$status);
                })
                ->latest()
                ->paginate(10)
                ->withQueryString();

            $monthlyBorrow = Borrowings::where('school_id',$user->school_id)
                ->selectRaw('MONTH(request_date) as month, COUNT(*) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total','month');

            return view('admin.dashboard',compact(
                'booksCount',
                'borrowedCount',
                'pending',
                'usersCount',
                'monthlyBorrow',
                'borrowings'
            ));
        }

        

        $user = $request->user();
        $booksCount = Book::where('school_id', $user->school_id)->count();
        $borrowedCount = borrowings::where('borrower_id', $user->id)->count();
        $borrowedPreview = borrowings::with('book')
        ->where('borrower_id', auth()->id())
        ->where('status','borrowed')
        ->latest()
        ->take(3)
        ->get();
        $search = request('search');

        $book = Book::where('school_id',$user->school_id)->when($search,function($q) use ($search){

        $q->where('title','like',"%$search%")
        ->orWhere('author','like',"%$search%");

        })->where('school_id',$user->school_id)->paginate(10);

        $info = information::where('school_id',$user->school_id)->get();
       return view('user.dashboard',compact('book','booksCount','borrowedCount','borrowedPreview','info'));
    }

    public function showInfo($id)
    {
        $information = Information::findOrFail($id);

        return view('user.detailInfo',compact('information'));
    }
}