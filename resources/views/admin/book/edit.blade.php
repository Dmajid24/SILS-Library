@extends('layouts.library')

@section('content')

<div class="w-full max-w-5xl mx-auto space-y-8">

{{-- ================= HEADER ================= --}}
<div>
    <h1 class="text-3xl font-bold flex items-center gap-2">
        <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            {{ __('book_form.edit_title') }}
        </span>
        <span>✏️</span>
    </h1>

    <p class="text-gray-500 mt-1">
        {{ __('book_form.edit_subtitle') }}
    </p>
</div>

{{-- ================= CARD ================= --}}
<div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-white/40 p-8">

<form action="{{ route('books.update',$book->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="grid lg:grid-cols-3 gap-10">

{{-- LEFT --}}
<div class="lg:col-span-2 space-y-6">

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">{{ __('book_form.fields.title') }}</label>
<input type="text" name="title"
value="{{ old('title',$book->title) }}"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm">
@error('title')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
</div>

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">{{ __('book_form.fields.author') }}</label>
<input type="text" name="author"
value="{{ old('author',$book->author) }}"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm">
@error('author')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
</div>

<div class="grid md:grid-cols-2 gap-6">

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">{{ __('book_form.fields.publisher') }}</label>
<input type="text" name="publisher"
value="{{ old('publisher',$book->publisher) }}"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm">
</div>

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">{{ __('book_form.fields.pages') }}</label>
<input type="number" name="page"
value="{{ old('page',$book->page) }}"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm">
</div>

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">{{ __('book_form.fields.isbn') }}</label>
<input type="text" name="isbn"
value="{{ old('isbn',$book->isbn) }}"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm">
</div>

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">{{ __('book_form.fields.stock') }}</label>
<input type="number" name="stock"
value="{{ old('stock',$book->stock) }}"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm">
</div>

</div>

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">{{ __('book_form.fields.description') }}</label>
<textarea name="description" rows="4"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm">{{ old('description',$book->description) }}</textarea>
</div>

</div>

{{-- RIGHT --}}
<div>

<label class="block text-sm font-medium text-gray-600 mb-2">{{ __('book_form.fields.cover') }}</label>

@if($book->cover)
<div class="mb-4">
    <p class="text-xs text-gray-400 mb-2">{{ __('book_form.current_cover') }}</p>
    <img src="{{ asset('storage/'.$book->cover) }}"
        class="w-32 h-44 object-cover rounded-xl shadow">
</div>
@endif

<label class="border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center p-6 cursor-pointer hover:border-indigo-500 transition">

<input type="file" name="cover" accept="image/*"
onchange="previewCover(event)" class="hidden">

<p class="text-gray-400 text-sm">{{ __('book_form.change_cover') }}</p>

<img id="coverPreview"
class="w-32 h-44 object-cover rounded-lg mt-4 hidden">

</label>

<p class="text-xs text-gray-400 mt-2">
{{ __('book_form.leave_empty') }}
</p>

@error('cover')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror

</div>

</div>

{{-- BUTTON --}}
<div class="flex justify-end gap-4 mt-10">

<a href="{{ route('books.index') }}"
class="px-6 py-2 rounded-xl border border-gray-300 hover:bg-gray-100 transition">
{{ __('book_form.cancel') }}
</a>

<button
class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow-md hover:scale-105 transition">
{{ __('book_form.update') }}
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