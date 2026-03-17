@extends('layouts.library')

@section('content')

<div class="max-w-6xl mx-auto space-y-8">

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
    {{ session('error') }}
</div>
@endif
{{-- BACK BUTTON --}}
<a href="{{ route('dashboard') }}" 
class="text-indigo-600 hover:underline font-medium">
← Back to Library
</a>


{{-- BOOK HEADER --}}
<div class="bg-gradient-to-r from-slate-800 via-indigo-800 to-slate-700 
rounded-3xl shadow-xl p-8 flex items-center gap-8">

{{-- COVER --}}
<img 
src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://placehold.co/120x160' }}"
class="w-28 h-40 object-cover rounded-xl shadow-lg">

{{-- BOOK INFO --}}
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


{{-- DESCRIPTION --}}
<div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-100">

<h2 class="text-xl font-semibold mb-4 text-gray-800">
Book Description
</h2>

<p class="text-gray-600 leading-relaxed">
{{ $book->description }}
</p>

</div>


{{-- BORROW --}}
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

<form id="borrowForm" action="{{ route('request.borrow',$book->id) }}" method="POST">
@csrf

<button type="button" onclick="openModal()" 
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

</div>
{{-- CONFIRM MODAL --}}
<div id="confirmModal" 
class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

<div class="bg-white rounded-2xl shadow-xl p-8 max-w-sm w-full text-center">

<h2 class="text-xl font-semibold mb-4">
Confirm Borrow
</h2>

<p class="text-gray-600 mb-6">
Are you sure you want to borrow this book?
</p>

<div class="flex justify-center gap-4">

<button onclick="submitBorrow()" 
class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg">
Yes
</button>

<button onclick="closeModal()" 
class="bg-gray-300 hover:bg-gray-400 px-5 py-2 rounded-lg">
No
</button>

</div>

</div>
</div>

<script>

function openModal(){
    document.getElementById('confirmModal').classList.remove('hidden');
    document.getElementById('confirmModal').classList.add('flex');
}

function closeModal(){
    document.getElementById('confirmModal').classList.add('hidden');
}

function submitBorrow(){
    document.getElementById('borrowForm').submit();
}

</script>
@endsection