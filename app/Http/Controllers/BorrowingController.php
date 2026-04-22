<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\borrowings;
use App\Models\book;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function active()
    {

        $borrowed = borrowings::with('book')
            ->where('borrower_id',auth()->id())
            ->whereIn('status',['requested', 'approved', 'borrowed'])
            ->latest()
            ->get();

        return view('user.myBorrowed',compact('borrowed'));
    }
    
    public function history()
    {
        
         $history = borrowings::with('book')
            ->where('borrower_id', auth()->id())
            ->where('status', 'returned')
            ->latest()
            ->get();
         return view('user.historyBorrowed',compact('history'));
    }


        

    public function show($id)
    {

        $borrow = borrowings::with('book')
            ->where('borrower_id',auth()->id())
            ->findOrFail($id);

        return view('user.borrowedShow',compact('borrow'));

    }
    public function requestUser(book $book)
    {
        if ($book->stock <= 0) {
            return back()->with('error','Book unavailable');
        }

        $existing = borrowings::where('borrower_id', auth()->id())
            ->where('book_id', $book->id)
            ->whereIn('status',['requested','borrowed'])
            ->exists();

        if($existing){
            return back()->with('error','You already borrowed or requested this book');
        }
        borrowings::create([
            'borrower_id' => auth()->id(),
            'book_id' => $book->id,
            'school_id' => auth()->user()->school_id,
            'request_date' => now(),
            'status' => 'requested'
        ]);

        return back()->with('success','Request sent');
    }
    // public function requestAdmin(book $book)
    // {
    //     if ($book->stock <= 0) {
    //         return back()->with('error','Book unavailable');
    //     }

    //     borrowings::create([
    //         'borrower_id' => auth()->id(),
    //         'book_id' => $book->id,
    //         'school_id' => auth()->user()->school_id,
    //         'request_date' => now(),
    //         'status' => 'pending'
    //     ]);

    //     return back()->with('success','Request sent');
    // }

    public function cancel($id)
    {
        $borrow = borrowings::findOrFail($id);

        if($borrow->borrower_id != auth()->id()){
            abort(403);
        }

        if($borrow->status != 'requested'){
            return back()->with('error','Cannot cancel this request');
        }

        $borrow->delete();

        return redirect()->route('borrowed.index')->with('success','Request cancelled');
    }
    public function approve(borrowings $borrowing)
    {
        $this->authorizeBorrowing($borrowing);

        $borrowing->update([
            'status' => 'approved',
            
        ]);
        $borrowing->book->decrement('stock'); 
        return back()->with('success','Approved');
    }

    public function reject(borrowings $borrowing){
        $this->authorizeBorrowing($borrowing);

        $borrowing->update([
            'status'=> 'rejected'
        ]);
        return back()->with('success','Rejected');
    }
    
    public function markBorrowed(borrowings $borrowing){
        $this->authorizeBorrowing($borrowing);

        $borrowing->update([
            'status'=> 'borrowed',
            'borrow_date' => now(),
            'due_date' => now()->addDays(7)
        ]);

        
        return back()->with('success','Book Picked Up');

    }
    public function return(borrowings $borrowing)
    {
        $this->authorizeBorrowing($borrowing);

        $borrowing->update([
            'status' => 'returned',
            'return_date' => now()
        ]);

        $borrowing->book->increment('stock');

        return back()->with('success','Returned');
    }
    private function authorizeBorrowing($borrowing)
    {
        if ($borrowing->school_id !== auth()->user()->school_id) {
            abort(403);
        }
    }   
}