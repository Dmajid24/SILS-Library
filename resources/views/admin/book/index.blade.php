@extends('layouts.library')

@section('content')

<div class="px-6 lg:px-10 space-y-8">

{{-- ================= HEADER ================= --}}
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 w-full">
    <div>
        <h1 class="text-3xl font-bold flex items-center gap-2">

            <span class="bg-gradient-to-r from-indigo-600 to-purple-600 
            bg-clip-text text-transparent">
                Manage Books
            </span>

            <span class="text-gray-800">📚</span>

        </h1>
        

        <p class="text-gray-500 mt-1">
            Manage your library collection easily
        </p>
    </div>

    <div class="flex gap-3 items-center">

        {{-- SEARCH --}}
        <form method="GET" class="relative">
            <input
            name="search"
            value="{{ request('search') }}"
            placeholder="🔎 Search books..."
            class="bg-white/80 backdrop-blur border border-white/50 
                   px-4 py-2 rounded-xl shadow-sm
                   focus:ring-2 focus:ring-indigo-400 outline-none transition"
            >
        </form>

        {{-- ADD BUTTON --}}
        <a href="{{ route('books.create') }}"
        class="bg-gradient-to-r from-indigo-600 to-purple-600 
               text-white px-5 py-2 rounded-xl shadow-md 
               hover:scale-105 transition">
        ➕ Add Book
        </a>

    </div>

</div>


{{-- ================= TABLE CARD ================= --}}
<div class="w-full bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-white/40 overflow-hidden">

<div class="overflow-x-auto">

<table class="w-full text-sm">

<thead class="bg-white/60 text-gray-500 text-xs uppercase tracking-wide">
<tr>
<th class="p-5 text-left">Book</th>
<th class="text-left">Author</th>
<th class="text-left">Stock</th>
<th class="text-left">ISBN</th>
<th class="text-center">Action</th>
</tr>
</thead>

<tbody>

@forelse($books as $book)

<tr class="border-b border-white/40 hover:bg-white/50 transition">

{{-- BOOK --}}
<td class="p-5 flex items-center gap-4">

<img
src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://via.placeholder.com/60x80' }}"
class="w-14 h-20 object-cover rounded-xl shadow-md">

<div>
<p class="font-semibold text-gray-800">
{{ $book->title }}
</p>

<p class="text-sm text-gray-400">
{{ $book->publisher }}
</p>
</div>

</td>


{{-- AUTHOR --}}
<td class="text-gray-600 font-medium">
{{ $book->author }}
</td>


{{-- STOCK --}}
<td>
@if($book->stock > 0)

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold shadow-sm">
{{ $book->stock }} Available
</span>

@else

<span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-semibold shadow-sm">
Out of Stock
</span>

@endif
</td>


{{-- ISBN --}}
<td class="text-gray-400 text-xs">
{{ $book->isbn }}
</td>


{{-- ACTION --}}
<td>

<div class="flex justify-center gap-2">

{{-- EDIT --}}
<a href="{{ route('books.edit',$book->id) }}"
class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-2 rounded-lg text-sm shadow transition">
✏️
</a>

{{-- DELETE --}}
<button
type="button"
onclick="openDeleteModal('{{ route('books.destroy',$book->id) }}')"
class="px-3 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white shadow">
🗑
</button>

</div>

</td>

</tr>

@empty

<tr>
<td colspan="5" class="text-center py-16 text-gray-400">
📭 No books available
</td>
</tr>

@endforelse

</tbody>

</table>

</div>


{{-- ================= PAGINATION ================= --}}
<div class="p-6 border-t border-white/40 bg-white/40">
{{ $books->links() }}
</div>

</div>

</div>


{{-- ================= DELETE MODAL ================= --}}
<div id="deleteModal"
class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50">

<div class="bg-white/90 backdrop-blur rounded-2xl shadow-xl p-6 max-w-sm w-full text-center">

<h2 class="text-lg font-semibold mb-3 text-gray-800">
Delete Book
</h2>

<p class="text-gray-500 mb-6 text-sm">
Are you sure you want to delete this book?  
This action cannot be undone.
</p>

<form id="deleteForm" method="POST">
    @csrf
    @method('DELETE')

    <button type="submit"
        class="bg-gradient-to-r from-red-500 to-red-600 text-white px-5 py-2 rounded-lg shadow hover:scale-105 transition">
        Yes, Delete
    </button>
</form>

<button
onclick="closeDeleteModal()"
class="mt-3 text-gray-500 text-sm hover:underline">
Cancel
</button>

</div>

</div>


{{-- ================= SCRIPT ================= --}}
<script>
function openDeleteModal(actionUrl){

    const modal = document.getElementById('deleteModal');
    const form  = document.getElementById('deleteForm');

    form.setAttribute('action', actionUrl);

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteModal(){
    document.getElementById('deleteModal')
        .classList.add('hidden');
}
</script>

@endsection