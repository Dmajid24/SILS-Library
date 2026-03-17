@extends('layouts.library')

@section('content')

<div class="max-w-4xl mx-auto">

{{-- HEADER --}}
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">
        ✏️ Edit Book
    </h1>
    <p class="text-gray-500">
        Update book information
    </p>
</div>

<div class="bg-white rounded-3xl shadow p-8">

<form action="{{ route('books.update',$book->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="grid md:grid-cols-2 gap-6">

{{-- TITLE --}}
<div>
<label class="font-medium">Title</label>
<input type="text"
name="title"
value="{{ old('title',$book->title) }}"
class="w-full mt-2 border rounded-xl px-4 py-2">
@error('title')
<p class="text-red-500 text-sm">{{ $message }}</p>
@enderror
</div>

{{-- AUTHOR --}}
<div>
<label class="font-medium">Author</label>
<input type="text"
name="author"
value="{{ old('author',$book->author) }}"
class="w-full mt-2 border rounded-xl px-4 py-2">
@error('author')
<p class="text-red-500 text-sm">{{ $message }}</p>
@enderror
</div>

{{-- PUBLISHER --}}
<div>
<label class="font-medium">Publisher</label>
<input type="text"
name="publisher"
value="{{ old('publisher',$book->publisher) }}"
class="w-full mt-2 border rounded-xl px-4 py-2">
</div>

{{-- PAGES --}}
<div>
<label class="font-medium">Pages</label>
<input type="number"
name="page"
value="{{ old('page',$book->page) }}"
class="w-full mt-2 border rounded-xl px-4 py-2">
</div>

{{-- ISBN --}}
<div>
<label class="font-medium">ISBN</label>
<input type="text"
name="isbn"
value="{{ old('isbn',$book->isbn) }}"
class="w-full mt-2 border rounded-xl px-4 py-2">
</div>

{{-- STOCK --}}
<div>
<label class="font-medium">Stock</label>
<input type="number"
name="stock"
value="{{ old('stock',$book->stock) }}"
class="w-full mt-2 border rounded-xl px-4 py-2">
</div>

</div>


{{-- COVER --}}
<div class="mt-6">

<label class="font-medium">Book Cover</label>

@if($book->cover)
<div class="mt-3 mb-4">
    <p class="text-sm text-gray-500 mb-2">Current Cover</p>
    <img src="{{ asset('storage/'.$book->cover) }}"
        class="w-32 h-40 object-cover rounded-lg shadow">
</div>
@endif

<input type="file"
name="cover"
accept="image/*"
onchange="previewCover(event)"
class="w-full border rounded-xl px-4 py-2">

<p class="text-xs text-gray-400 mt-1">
Leave empty if you don't want to change cover
</p>

<div class="mt-4">
<img id="coverPreview"
class="w-32 h-40 object-cover rounded-lg hidden">
</div>

@error('cover')
<p class="text-red-500 text-sm">{{ $message }}</p>
@enderror

</div>


{{-- DESCRIPTION --}}
<div class="mt-6">

<label class="font-medium">Description</label>

<textarea name="description"
rows="4"
class="w-full mt-2 border rounded-xl px-4 py-2">{{ old('description',$book->description) }}</textarea>

</div>


{{-- BUTTON --}}
<div class="flex justify-end gap-4 mt-8">

<a href="{{ route('books.index') }}"
class="border px-6 py-2 rounded-xl hover:bg-gray-100">
Cancel
</a>

<button
class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2 rounded-xl shadow">
Update Book
</button>

</div>

</form>

</div>

</div>


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