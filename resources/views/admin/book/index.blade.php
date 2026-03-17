@extends('layouts.library')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

{{-- HEADER --}}
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

<div>
<h1 class="text-3xl font-bold text-gray-800">
📚 Manage Books
</h1>

<p class="text-gray-500">
Edit and manage library collection
</p>
</div>


<div class="flex gap-3 items-center">

<form method="GET">
<input
name="search"
value="{{ request('search') }}"
placeholder="Search book..."
class="border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"
>
</form>

<a href="{{ route('books.create') }}"
class="bg-indigo-600 text-white px-5 py-2 rounded-xl shadow hover:bg-indigo-700 transition">
➕ Add Book
</a>

</div>

</div>


{{-- TABLE CARD --}}
<div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

<div class="overflow-x-auto">

<table class="w-full text-sm">

<thead class="bg-gray-50 text-gray-600">
<tr>
<th class="p-4 text-left">Book</th>
<th class="text-left">Author</th>
<th class="text-left">Stock</th>
<th class="text-left">ISBN</th>
<th class="text-center">Action</th>
</tr>
</thead>

<tbody>

@forelse($books as $book)

<tr class="border-b hover:bg-indigo-50 transition">

{{-- BOOK INFO --}}
<td class="p-4 flex items-center gap-4">

<img
src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://via.placeholder.com/60x80' }}"
class="w-14 h-20 object-cover rounded-lg shadow">

<div>
<p class="font-semibold text-gray-800">
{{ $book->title }}
</p>

<p class="text-sm text-gray-400">
{{ $book->publisher }}
</p>
</div>

</td>


<td class="text-gray-600">
{{ $book->author }}
</td>


<td>

@if($book->stock > 0)

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
{{ $book->stock }} Available
</span>

@else

<span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-semibold">
Out of Stock
</span>

@endif

</td>


<td class="text-gray-500">
{{ $book->isbn }}
</td>


{{-- ACTION --}}
<td>

<div class="flex justify-center gap-2">

<a href="{{ route('books.edit',$book->id) }}"
class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-2 rounded-lg text-sm transition">
✏️
</a>

<form action="{{ route('books.destroy',$book->id) }}"
method="POST"
onsubmit="return confirm('Delete this book?')">

@csrf
@method('DELETE')

<button
class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm transition">
🗑
</button>

</form>

</div>

</td>

</tr>

@empty

<tr>
<td colspan="5" class="text-center py-10 text-gray-400">
No books available
</td>
</tr>

@endforelse

</tbody>

</table>

</div>


{{-- PAGINATION --}}
<div class="p-6 border-t">
{{ $books->links() }}
</div>

</div>

</div>

@endsection