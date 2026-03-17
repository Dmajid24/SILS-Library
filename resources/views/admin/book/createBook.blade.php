@extends('layouts.library')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">

{{-- HEADER --}}
<div>
<h1 class="text-3xl font-bold text-gray-800">
📚 Add New Book
</h1>

<p class="text-gray-500">
Insert a new book into the library collection
</p>
</div>


<div class="bg-white rounded-3xl shadow p-8">

<form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
@csrf


<div class="grid md:grid-cols-3 gap-8">

{{-- LEFT FORM --}}
<div class="md:col-span-2 space-y-6">

{{-- TITLE --}}
<div>
<label class="block font-medium text-gray-600 mb-1">
Title
</label>

<input
type="text"
name="title"
value="{{ old('title') }}"
class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-purple-500 outline-none">

@error('title')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
</div>


{{-- AUTHOR --}}
<div>
<label class="block font-medium text-gray-600 mb-1">
Author
</label>

<input
type="text"
name="author"
value="{{ old('author') }}"
class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-purple-500 outline-none">

@error('author')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
</div>


<div class="grid md:grid-cols-2 gap-6">

{{-- PUBLISHER --}}
<div>
<label class="block font-medium text-gray-600 mb-1">
Publisher
</label>

<input
type="text"
name="publisher"
value="{{ old('publisher') }}"
class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-purple-500 outline-none">
</div>


{{-- PAGES --}}
<div>
<label class="block font-medium text-gray-600 mb-1">
Pages
</label>

<input
type="number"
name="page"
value="{{ old('page') }}"
class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-purple-500 outline-none">
</div>


{{-- ISBN --}}
<div>
<label class="block font-medium text-gray-600 mb-1">
ISBN
</label>

<input
type="text"
name="isbn"
value="{{ old('isbn') }}"
class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-purple-500 outline-none">
</div>


{{-- STOCK --}}
<div>
<label class="block font-medium text-gray-600 mb-1">
Stock
</label>

<input
type="number"
name="stock"
value="{{ old('stock') }}"
class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-purple-500 outline-none">
</div>

</div>


{{-- DESCRIPTION --}}
<div>
<label class="block font-medium text-gray-600 mb-1">
Description
</label>

<textarea
name="description"
rows="4"
class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-purple-500 outline-none">{{ old('description') }}</textarea>
</div>

</div>



{{-- RIGHT SIDE --}}
<div>

<label class="block font-medium text-gray-600 mb-2">
Book Cover
</label>

<label
class="border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center p-6 cursor-pointer hover:border-purple-500 transition">

<input
type="file"
name="cover"
accept="image/*"
onchange="previewCover(event)"
class="hidden">

<p class="text-gray-400 text-sm">
Click to upload cover
</p>

<img
id="coverPreview"
class="w-32 h-40 object-cover rounded-lg mt-4 hidden">

</label>

@error('cover')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror

</div>

</div>


{{-- BUTTON --}}
<div class="flex justify-end gap-4 mt-8">

<a
href="{{ route('dashboard') }}"
class="px-6 py-2 rounded-xl border border-gray-300 hover:bg-gray-100 transition">
Cancel
</a>

<button
class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2 rounded-xl shadow transition">
Save Book
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