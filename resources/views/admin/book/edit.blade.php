@extends('layouts.library')

@section('content')

<div class="w-full max-w-5xl mx-auto space-y-8">

{{-- ================= HEADER ================= --}}
<div>
    <h1 class="text-3xl font-bold flex items-center gap-2">
        <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            Edit Book
        </span>
        <span>✏️</span>
    </h1>

    <p class="text-gray-500 mt-1">
        Update book information
    </p>
</div>


{{-- ================= CARD ================= --}}
<div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-white/40 p-8">

<form action="{{ route('books.update',$book->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="grid lg:grid-cols-3 gap-10">

{{-- ================= LEFT ================= --}}
<div class="lg:col-span-2 space-y-6">

{{-- TITLE --}}
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">Title</label>
<input type="text" name="title"
value="{{ old('title',$book->title) }}"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm
focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400
hover:border-indigo-300 focus:shadow-lg outline-none transition">
@error('title')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
</div>

{{-- AUTHOR --}}
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">Author</label>
<input type="text" name="author"
value="{{ old('author',$book->author) }}"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm
focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400
hover:border-indigo-300 focus:shadow-lg outline-none transition">
@error('author')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
</div>

<div class="grid md:grid-cols-2 gap-6">

{{-- PUBLISHER --}}
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">Publisher</label>
<input type="text" name="publisher"
value="{{ old('publisher',$book->publisher) }}"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm
focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400
hover:border-indigo-300 focus:shadow-lg outline-none transition">
</div>

{{-- PAGES --}}
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">Pages</label>
<input type="number" name="page"
value="{{ old('page',$book->page) }}"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm
focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400
hover:border-indigo-300 focus:shadow-lg outline-none transition">
</div>

{{-- ISBN --}}
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">ISBN</label>
<input type="text" name="isbn"
value="{{ old('isbn',$book->isbn) }}"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm
focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400
hover:border-indigo-300 focus:shadow-lg outline-none transition">
</div>

{{-- STOCK --}}
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">Stock</label>
<input type="number" name="stock"
value="{{ old('stock',$book->stock) }}"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm
focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400
hover:border-indigo-300 focus:shadow-lg outline-none transition">
</div>

</div>

{{-- DESCRIPTION --}}
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">Description</label>
<textarea name="description" rows="4"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm
focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400
hover:border-indigo-300 focus:shadow-lg outline-none transition">{{ old('description',$book->description) }}</textarea>
</div>

</div>


{{-- ================= RIGHT (COVER) ================= --}}
<div>

<label class="block text-sm font-medium text-gray-600 mb-2">Book Cover</label>

{{-- CURRENT --}}
@if($book->cover)
<div class="mb-4">
    <p class="text-xs text-gray-400 mb-2">Current Cover</p>
    <img src="{{ asset('storage/'.$book->cover) }}"
        class="w-32 h-44 object-cover rounded-xl shadow">
</div>
@endif

{{-- UPLOAD --}}
<label class="border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center p-6 cursor-pointer hover:border-indigo-500 transition">

<input type="file" name="cover" accept="image/*"
onchange="previewCover(event)" class="hidden">

<p class="text-gray-400 text-sm">Click to change cover</p>

<img id="coverPreview"
class="w-32 h-44 object-cover rounded-lg mt-4 hidden">

</label>

<p class="text-xs text-gray-400 mt-2">
Leave empty if you don't want to change
</p>

@error('cover')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror

</div>

</div>


{{-- ================= BUTTON ================= --}}
<div class="flex justify-end gap-4 mt-10">

<a href="{{ route('books.index') }}"
class="px-6 py-2 rounded-xl border border-gray-300 hover:bg-gray-100 transition">
Cancel
</a>

<button
class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow-md hover:scale-105 transition">
Update Book
</button>

</div>

</form>

</div>

</div>


{{-- ================= SCRIPT ================= --}}
<script>
function previewCover(event){
    const reader = new FileReader();

    reader.onload = function(){
        const img = document.getElementById('coverPreview');
        img.src = reader.result;
        img.classList.remove('hidden');
    }

    reader.readAsDataURL(event.target.files[0]);
}
</script>

@endsection