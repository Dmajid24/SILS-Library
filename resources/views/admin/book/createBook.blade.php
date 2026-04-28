@extends('layouts.library')

@section('content')

<div class="w-full space-y-8">

{{-- ================= HEADER ================= --}}
<div>
    <h1 class="text-3xl font-bold flex items-center gap-2">
        <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            {{ __('book_create.title') }}
        </span>
        <span>📚</span>
    </h1>

    <p class="text-gray-500 mt-1">
        {{ __('book_create.subtitle') }}
    </p>
</div>

{{-- ================= FORM CARD ================= --}}
<div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-white/40 p-8">

<form id="bookForm" action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="grid lg:grid-cols-3 gap-10">

{{-- LEFT --}}
<div class="lg:col-span-2 space-y-6">

<div>
<label class="block font-medium text-gray-600 mb-1">
    {{ __('book_create.fields.title') }}
</label>
<input type="text" name="title" value="{{ old('title') }}"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-400">
@error('title')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
</div>

<div>
<label class="block font-medium text-gray-600 mb-1">
    {{ __('book_create.fields.author') }}
</label>
<input type="text" name="author" value="{{ old('author') }}"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-400">
@error('author')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
</div>

<div class="grid md:grid-cols-2 gap-6">

<div>
<label class="block font-medium text-gray-600 mb-1">
    {{ __('book_create.fields.publisher') }}
</label>
<input type="text" name="publisher" value="{{ old('publisher') }}"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm">
</div>

<div>
<label class="block font-medium text-gray-600 mb-1">
    {{ __('book_create.fields.pages') }}
</label>
<input type="number" name="page" value="{{ old('page') }}"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm">
</div>

<div>
<label class="block font-medium text-gray-600 mb-1">
    {{ __('book_create.fields.isbn') }}
</label>
<input type="text" name="isbn" value="{{ old('isbn') }}"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm">
</div>

<div>
<label class="block font-medium text-gray-600 mb-1">
    {{ __('book_create.fields.stock') }}
</label>
<input type="number" name="stock" value="{{ old('stock') }}"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm">
</div>

</div>

<div>
<label class="block font-medium text-gray-600 mb-1">
    {{ __('book_create.fields.description') }}
</label>
<textarea name="description" rows="4"
class="w-full bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm">{{ old('description') }}</textarea>
</div>

</div>

{{-- RIGHT --}}
<div>

<label class="block font-medium text-gray-600 mb-2">
    {{ __('book_create.fields.cover') }}
</label>

<label class="border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center p-6 cursor-pointer hover:border-indigo-500 transition">

<input type="file" name="cover" accept="image/*" onchange="previewCover(event)" class="hidden">

<p class="text-gray-400 text-sm">
    {{ __('book_create.upload_text') }}
</p>

<img id="coverPreview" class="w-32 h-44 object-cover rounded-lg mt-4 hidden">

</label>

@error('cover')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror

</div>

</div>

{{-- BUTTON --}}
<div class="flex justify-end gap-4 mt-10">

<a href="{{ route('books.index') }}"
class="px-6 py-2 rounded-xl border border-gray-300 hover:bg-gray-100 transition">
    {{ __('book_create.cancel') }}
</a>

<button type="button"
onclick="validateBeforeModal()"
class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow-md hover:scale-105 transition">
    {{ __('book_create.save') }}
</button>

</div>

</form>

</div>

</div>

{{-- MODAL --}}
<div id="confirmModal"
class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50">

<div class="bg-white rounded-2xl shadow-xl p-6 max-w-sm w-full text-center">

<h2 class="text-lg font-semibold text-gray-800 mb-3">
    {{ __('book_create.confirm_title') }}
</h2>

<p class="text-gray-500 text-sm mb-6">
    {{ __('book_create.confirm_message') }}
</p>

<button onclick="submitForm()"
class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-2 rounded-lg hover:scale-105 transition mb-2">
    {{ __('book_create.confirm_yes') }}
</button>

<button onclick="closeModal()"
class="text-gray-500 text-sm hover:underline">
    {{ __('book_create.cancel') }}
</button>

</div>
</div>

<script>
function validateBeforeModal(){
    const form = document.getElementById('bookForm');
    if(form.checkValidity()){
        openModal();
    } else {
        form.reportValidity();
    }
}

function openModal(){
    document.getElementById('confirmModal').classList.remove('hidden');
    document.getElementById('confirmModal').classList.add('flex');
}

function closeModal(){
    document.getElementById('confirmModal').classList.add('hidden');
    document.getElementById('confirmModal').classList.remove('flex');
}

function submitForm(){
    document.getElementById('bookForm').submit();
}

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