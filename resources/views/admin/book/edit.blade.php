@extends('layouts.library')

@section('content')

<div class="w-full max-w-5xl mx-auto space-y-8 px-4 sm:px-6 lg:px-0">

{{-- ================= HEADER ================= --}}
<div>
    <h1 class="text-2xl sm:text-3xl font-bold flex flex-wrap items-center gap-2">
        <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            {{ __('book_form.edit_title') }}
        </span>
        <span>✏️</span>
    </h1>

    <p class="text-gray-500 mt-1 text-sm sm:text-base">
        {{ __('book_form.edit_subtitle') }}
    </p>
</div>

{{-- ================= CARD ================= --}}
<div class="bg-white/70 backdrop-blur-xl rounded-2xl sm:rounded-3xl shadow-xl border border-white/40 p-4 sm:p-6 lg:p-8">

<form action="{{ route('books.update',$book->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">

{{-- LEFT --}}
<div class="lg:col-span-2 space-y-6">

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
    {{ __('book_form.fields.title') }}
</label>

<input type="text" name="title"
value="{{ old('title',$book->title) }}"
class="w-full bg-white border border-gray-200 px-4 py-3 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-400 text-sm sm:text-base">

@error('title')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
</div>

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
    {{ __('book_form.fields.author') }}
</label>

<input type="text" name="author"
value="{{ old('author',$book->author) }}"
class="w-full bg-white border border-gray-200 px-4 py-3 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-400 text-sm sm:text-base">

@error('author')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
    {{ __('book_form.fields.publisher') }}
</label>

<input type="text" name="publisher"
value="{{ old('publisher',$book->publisher) }}"
class="w-full bg-white border border-gray-200 px-4 py-3 rounded-xl shadow-sm text-sm sm:text-base">
</div>

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
    {{ __('book_form.fields.pages') }}
</label>

<input type="number" name="page"
value="{{ old('page',$book->page) }}"
class="w-full bg-white border border-gray-200 px-4 py-3 rounded-xl shadow-sm text-sm sm:text-base">
</div>

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
    {{ __('book_form.fields.isbn') }}
</label>

<input type="text" name="isbn"
value="{{ old('isbn',$book->isbn) }}"
class="w-full bg-white border border-gray-200 px-4 py-3 rounded-xl shadow-sm text-sm sm:text-base">
</div>

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
    {{ __('book_form.fields.stock') }}
</label>

<input type="number" name="stock"
value="{{ old('stock',$book->stock) }}"
class="w-full bg-white border border-gray-200 px-4 py-3 rounded-xl shadow-sm text-sm sm:text-base">
</div>

</div>

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
    {{ __('book_form.fields.description') }}
</label>

<textarea name="description" rows="4"
class="w-full bg-white border border-gray-200 px-4 py-3 rounded-xl shadow-sm resize-none text-sm sm:text-base">{{ old('description',$book->description) }}</textarea>
</div>

</div>

{{-- RIGHT --}}
<div>

<label class="block text-sm font-medium text-gray-600 mb-2">
    {{ __('book_form.fields.cover') }}
</label>

@if($book->cover)
<div class="mb-4">
    <p class="text-xs text-gray-400 mb-2">
        {{ __('book_form.current_cover') }}
    </p>

    <img src="{{ asset('storage/'.$book->cover) }}"
        class="w-28 sm:w-32 h-40 sm:h-44 object-cover rounded-xl shadow">
</div>
@endif

<label class="border-2 border-dashed border-gray-300 rounded-2xl flex flex-col items-center justify-center p-5 sm:p-6 cursor-pointer hover:border-indigo-500 transition bg-white/70 min-h-[250px]">

<input type="file" name="cover" accept="image/*"
onchange="previewCover(event)" class="hidden">

<p class="text-gray-400 text-sm text-center">
    {{ __('book_form.change_cover') }}
</p>

<img id="coverPreview"
class="w-28 sm:w-32 h-40 sm:h-44 object-cover rounded-lg mt-4 hidden shadow">

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
<div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-10">

<a href="{{ route('books.index') }}"
class="w-full sm:w-auto text-center px-6 py-3 rounded-xl border border-gray-300 hover:bg-gray-100 transition text-sm sm:text-base">
{{ __('book_form.cancel') }}
</a>

<button
class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow-md hover:scale-[1.02] transition text-sm sm:text-base">
{{ __('book_form.update') }}
</button>

</div>

</form>

</div>

</div>

<script>
function previewCover(event){
    const file = event.target.files[0];
    if(!file) return;

    const reader = new FileReader();

    reader.onload = function(){
        const img = document.getElementById('coverPreview');
        img.src = reader.result;
        img.classList.remove('hidden');
    }

    reader.readAsDataURL(file);
}
</script>

@endsection