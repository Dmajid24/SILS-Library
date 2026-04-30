@extends('layouts.library')

@section('content')

<div class="w-full space-y-8 px-4 sm:px-6 lg:px-0">

    {{-- ================= HEADER ================= --}}
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold flex flex-wrap items-center gap-2">
            <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                {{ __('book_form.add_title') }}
            </span>
            <span>📚</span>
        </h1>

        <p class="text-gray-500 mt-1 text-sm sm:text-base">
            {{ __('book_form.add_subtitle') }}
        </p>
    </div>

    {{-- ================= FORM CARD ================= --}}
    <div class="bg-white/70 backdrop-blur-xl rounded-2xl sm:rounded-3xl shadow-xl border border-white/40 p-4 sm:p-6 lg:p-8">

        <form id="bookForm" action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">

                {{-- LEFT SIDE --}}
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <label class="block font-medium text-gray-600 mb-1 text-sm sm:text-base">
                            {{ __('book_form.fields.title') }}
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="w-full bg-white border border-gray-200 px-4 py-3 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-400 text-sm sm:text-base">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-gray-600 mb-1 text-sm sm:text-base">
                            {{ __('book_form.fields.author') }}
                        </label>
                        <input type="text" name="author" value="{{ old('author') }}"
                            class="w-full bg-white border border-gray-200 px-4 py-3 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-400 text-sm sm:text-base">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block font-medium text-gray-600 mb-1 text-sm sm:text-base">
                                {{ __('book_form.fields.publisher') }}
                            </label>
                            <input type="text" name="publisher" value="{{ old('publisher') }}"
                                class="w-full bg-white border border-gray-200 px-4 py-3 rounded-xl shadow-sm text-sm sm:text-base">
                        </div>

                        <div>
                            <label class="block font-medium text-gray-600 mb-1 text-sm sm:text-base">
                                {{ __('book_form.fields.pages') }}
                            </label>
                            <input type="number" name="page" value="{{ old('page') }}"
                                class="w-full bg-white border border-gray-200 px-4 py-3 rounded-xl shadow-sm text-sm sm:text-base">
                        </div>

                        <div>
                            <label class="block font-medium text-gray-600 mb-1 text-sm sm:text-base">
                                {{ __('book_form.fields.isbn') }}
                            </label>
                            <input type="text" name="isbn" value="{{ old('isbn') }}"
                                class="w-full bg-white border border-gray-200 px-4 py-3 rounded-xl shadow-sm text-sm sm:text-base">
                        </div>

                        <div>
                            <label class="block font-medium text-gray-600 mb-1 text-sm sm:text-base">
                                {{ __('book_form.fields.stock') }}
                            </label>
                            <input type="number" name="stock" value="{{ old('stock') }}"
                                class="w-full bg-white border border-gray-200 px-4 py-3 rounded-xl shadow-sm text-sm sm:text-base">
                        </div>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-600 mb-1 text-sm sm:text-base">
                            {{ __('book_form.fields.description') }}
                        </label>
                        <textarea name="description" rows="4"
                            class="w-full bg-white border border-gray-200 px-4 py-3 rounded-xl shadow-sm text-sm sm:text-base resize-none">{{ old('description') }}</textarea>
                    </div>
                </div>

                {{-- RIGHT SIDE --}}
                <div>
                    <label class="block font-medium text-gray-600 mb-2 text-sm sm:text-base">
                        {{ __('book_form.fields.cover') }}
                    </label>

                    <label class="border-2 border-dashed border-gray-300 rounded-2xl flex flex-col items-center justify-center p-5 sm:p-6 cursor-pointer hover:border-indigo-500 transition bg-white/70 min-h-[250px]">
                        <input type="file" name="cover" accept="image/*" onchange="previewCover(event)" class="hidden">
                        
                        <p id="previewText" class="text-gray-400 text-sm text-center">
                            {{ __('book_form.upload_text') }}
                        </p>

                        <img id="coverPreview" class="w-28 sm:w-32 h-40 sm:h-44 object-cover rounded-lg mt-4 hidden shadow">
                    </label>

                    @error('cover')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- BUTTONS --}}
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-10">
                <a href="{{ route('books.index') }}"
                    class="w-full sm:w-auto text-center px-6 py-3 rounded-xl border border-gray-300 hover:bg-gray-100 transition text-sm sm:text-base">
                    {{ __('book_form.cancel') }}
                </a>

                <button type="button" onclick="validateBeforeModal()"
                    class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow-md hover:scale-[1.02] transition text-sm sm:text-base font-semibold">
                    {{ __('book_form.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL --}}
<div id="confirmModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-xl p-6 max-w-sm w-full text-center">
        <h2 class="text-lg font-semibold text-gray-800 mb-3">
            {{ __('book_form.confirm_title') }}
        </h2>
        <p class="text-gray-500 text-sm mb-6">
            {{ __('book_form.confirm_message') }}
        </p>

        <button onclick="submitForm()"
            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-lg hover:scale-[1.02] transition mb-2">
            {{ __('book_form.confirm_yes') }}
        </button>

        <button onclick="closeModal()" class="text-gray-500 text-sm hover:underline">
            {{ __('book_form.cancel') }}
        </button>
    </div>
</div>

<script>
    function validateBeforeModal() {
        const form = document.getElementById('bookForm');
        if (form.checkValidity()) {
            openModal();
        } else {
            form.reportValidity();
        }
    }

    function openModal() {
        document.getElementById('confirmModal').classList.remove('hidden');
        document.getElementById('confirmModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('confirmModal').classList.add('hidden');
        document.getElementById('confirmModal').classList.remove('flex');
    }

    function submitForm() {
        document.getElementById('bookForm').submit();
    }

    function previewCover(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function() {
            const img = document.getElementById('coverPreview');
            const txt = document.getElementById('previewText');
            img.src = reader.result;
            img.classList.remove('hidden');
            txt.classList.add('hidden');
        }
        reader.readAsDataURL(file);
    }
</script>

@endsection