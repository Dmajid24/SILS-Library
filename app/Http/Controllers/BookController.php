<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $search = request('search');

       $books = Book::where('school_id',Auth::user()->school_id)->when($search,function($q) use ($search){

        $q->where('title','like',"%$search%")
        ->orWhere('author','like',"%$search%");

        })->where('school_id',Auth::user()->school_id)->paginate(10);

        return view('admin.book.index', compact('books'));
    }

    public function create(){
        if(auth()->user()->role !== 'admin'){
            abort(403);
        };
        return view('admin.book.createBook');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'isbn' => 'required|min:13',
            'title' => 'required',
            'description' => 'required',
            'page' => 'required|integer',
            'author' => 'required',
            'publisher' => 'required',
            'stock' => 'required|integer|min:1'
        ]);

        $data['school_id'] = Auth::user()->school_id;

        if($request->hasFile('cover')){
            $data['cover'] = $request->file('cover')->store('book_covers','public');
        }
        Book::create($data);

        return redirect()->route('books.index')->with('success','Book added');
    }
    public function show($id){

        $book = Book::where('id', $id)->with(['reviews' => function($q){
            $q->latest()->take(5);
        }, 'reviews.user'])
        ->firstOrFail();
        return view('user.detail', compact('book'));
    }

    // UPDATE
    public function edit(book $book){
        $this->authorizeBook($book);
        return view('admin.book.edit',compact('book'));
    }
   public function update(Request $request, Book $book)
    {
        $this->authorizeBook($book);

        $data = $request->validate([
            'isbn' => 'required|min:13',
            'title' => 'required',
            'description' => 'required',
            'page' => 'required|integer',
            'author' => 'required',
            'publisher' => 'required',
            'stock' => 'required|integer|min:1',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if($request->hasFile('cover')){

            if($book->cover){
                Storage::disk('public')->delete($book->cover);
            }

            $data['cover'] = $request->file('cover')->store('book_covers','public');
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success','Updated');
    }

    // DELETE
    public function destroy(Book $book)
    {
        $this->authorizeBook($book);

        $book->delete();

        return back()->with('success','Book Deleted');
    }

    private function authorizeBook(Book $book)
    {
        if ($book->school_id !== Auth::user()->school_id) {
            abort(403);
        }
    }
}