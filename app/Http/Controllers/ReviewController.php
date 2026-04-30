<?php

namespace App\Http\Controllers;
use App\Models\Review;
use App\Models\Book;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Book $book)
{
    $reviews = $book->reviews()->with('user')->latest()->paginate(10);

    return view('user.review.index', compact('book','reviews'));
}
    public function store(Request $request, $bookId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500'
        ]);

        Review::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'book_id' => $bookId
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment
            ]
        );

        return back()->with('success','Review submitted!');
    }
    public function destroy($id)
    {
        Review::findOrFail($id)->delete();

        return back()->with('success','Review deleted');
    }
}

