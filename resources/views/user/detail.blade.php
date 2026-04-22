@extends('layouts.library')

@section('content')

<div class="max-w-6xl mx-auto space-y-8">

{{-- BACK BUTTON --}}
<a href="{{ route('dashboard') }}" 
class="text-indigo-600 hover:underline font-medium">
← Back to Library
</a>


{{-- ================= BOOK HEADER ================= --}}
<div class="bg-gradient-to-r from-slate-800 via-indigo-800 to-slate-700 
rounded-3xl shadow-xl p-8 flex items-center gap-8">

<img 
src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://placehold.co/120x160' }}"
class="w-28 h-40 object-cover rounded-xl shadow-lg">

<div class="text-white flex-1">

<h1 class="text-3xl font-bold mb-2">
{{ $book->title }}
</h1>

<p class="text-gray-200 mb-4">
by {{ $book->author }}
</p>

<div class="flex flex-wrap gap-3 text-sm">

<span class="bg-white/20 px-4 py-2 rounded-full">
📚 {{ $book->publisher }}
</span>

<span class="bg-white/20 px-4 py-2 rounded-full">
📄 {{ $book->page }} pages
</span>

<span class="bg-white/20 px-4 py-2 rounded-full">
🏷 ISBN {{ $book->isbn }}
</span>

@if($book->stock > 0)
<span class="bg-green-500 px-4 py-2 rounded-full font-semibold">
✔ {{ $book->stock }} Available
</span>
@else
<span class="bg-red-500 px-4 py-2 rounded-full font-semibold">
Out of Stock
</span>
@endif

</div>
</div>
</div>


{{-- ================= DESCRIPTION ================= --}}
<div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-100">

<h2 class="text-xl font-semibold mb-4 text-gray-800">
Book Description
</h2>

<p class="text-gray-600 leading-relaxed">
{{ $book->description }}
</p>

</div>


{{-- ================= BORROW SECTION ================= --}}
<div class="bg-white rounded-3xl shadow-lg p-8 flex justify-between items-center border border-gray-100">

<div>
<h2 class="text-lg font-semibold text-gray-800">
Borrow this Book
</h2>

<p class="text-gray-500 text-sm">
Request borrowing if the book is available
</p>
</div>


@if($book->stock > 0)

<form id="borrowRequestForm" action="{{ route('request.borrow',$book->id) }}" method="POST">
@csrf

<button type="button"
onclick="borrowModal.open()"
class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl shadow-md transition">
📚 Request Borrow
</button>

</form>

@else

<button class="bg-gray-300 text-gray-600 px-6 py-3 rounded-xl cursor-not-allowed">
Not Available
</button>

@endif

</div>
{{-- ================= REVIEW SECTION ================= --}}
<div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-100 space-y-6">

<h2 class="text-xl font-semibold text-gray-800">
⭐ User Reviews
</h2>

{{-- FORM --}}
<form method="POST" action="{{ route('review.store',$book->id) }}" class="space-y-4">
@csrf

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Your Rating
    </label>

    <select name="rating"
        class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

        <option value="">Select Rating</option>
        <option value="5">⭐⭐⭐⭐⭐ (5)</option>
        <option value="4">⭐⭐⭐⭐ (4)</option>
        <option value="3">⭐⭐⭐ (3)</option>
        <option value="2">⭐⭐ (2)</option>
        <option value="1">⭐ (1)</option>
    </select>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Comment
    </label>

    <textarea name="comment" rows="3"
        class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
        placeholder="Write your thoughts..."></textarea>
</div>

<button type="submit"
class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl shadow">
Submit Review
</button>

</form>

<div class="flex justify-between items-center">
    <h2 class="text-xl font-semibold text-gray-800">
        ⭐ User Reviews
    </h2>

    <a href="{{ route('review.index',$book->id) }}"
       class="text-indigo-600 text-sm font-medium hover:underline">
        View All →
    </a>
</div>
{{-- LIST REVIEW --}}
<div class="space-y-4">

@forelse($book->reviews as $review)

<div class="bg-gray-50 p-4 rounded-xl border">

<div class="flex justify-between items-center mb-2">
    <span class="font-semibold text-gray-800">
        {{ $review->user->first_name }}
    </span>

    <span class="text-yellow-500 text-sm">
        {!! str_repeat('⭐',$review->rating) !!}
    </span>
</div>

<p class="text-gray-600 text-sm">
    {{ $review->comment }}
</p>

</div>

@empty

<p class="text-gray-400 text-sm">
No reviews yet. Be the first!
</p>

@endforelse

</div>

</div>

</div>

{{-- ================= BORROW MODAL ================= --}}
<div id="borrow-modal"
class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-[999] transition">

<div class="bg-white rounded-3xl shadow-2xl p-8 max-w-sm w-full text-center 
transform scale-95 opacity-0 transition duration-300"
id="modal-content">

<div class="text-4xl mb-3">📚</div>

<h2 class="text-xl font-semibold mb-2 text-gray-800">
Confirm Borrow
</h2>

<p class="text-gray-500 mb-6">
Are you sure you want to borrow this book?
</p>

<div class="flex justify-center gap-3">

<button onclick="borrowModal.submit()" 
class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl shadow">
Yes, Borrow
</button>

<button onclick="borrowModal.close()" 
class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-xl">
Cancel
</button>

</div>

</div>
</div>


{{-- ================= SAFE JS (ANTI-CONFLICT) ================= --}}
<script>

const borrowModal = {

    modal: document.getElementById('borrow-modal'),
    content: document.getElementById('modal-content'),

    open(){
        this.modal.classList.remove('hidden');
        this.modal.classList.add('flex');

        setTimeout(() => {
            this.content.classList.remove('scale-95','opacity-0');
            this.content.classList.add('scale-100','opacity-100');
        }, 10);
    },

    close(){
        this.content.classList.remove('scale-100','opacity-100');
        this.content.classList.add('scale-95','opacity-0');

        setTimeout(() => {
            this.modal.classList.add('hidden');
            this.modal.classList.remove('flex');
        }, 200);
    },

    submit(){
        document.getElementById('borrowRequestForm').submit();
    }
};


// close when click background
borrowModal.modal.addEventListener('click', function(e){
    if(e.target === this){
        borrowModal.close();
    }
});

</script>

@endsection