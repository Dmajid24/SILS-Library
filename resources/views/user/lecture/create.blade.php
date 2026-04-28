@extends('layouts.library')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">

    {{-- ================= HERO IMAGE ================= --}}
    <div class="relative rounded-3xl overflow-hidden shadow-lg">

        @if($information->image_content)
            <img src="{{ asset('storage/'.$information->image_content) }}"
                 class="w-full h-80 object-cover">
        @else
            <div class="w-full h-80 bg-gradient-to-r from-indigo-400 to-purple-500"></div>
        @endif

        {{-- OVERLAY --}}
        <div class="absolute inset-0 bg-black/30"></div>

        {{-- TITLE OVER IMAGE --}}
        <div class="absolute bottom-0 p-8 text-white">
            <h1 class="text-3xl md:text-4xl font-bold leading-tight">
                {{-- Dinamis berdasarkan locale --}}
                {{ app()->getLocale() == 'en' ? ($information->title_en ?? $information->title) : $information->title }}
            </h1>

            <p class="text-sm text-white/80 mt-2">
                {{ __('announcements.published_on') }} {{ $information->created_at->format('d M Y') }}
            </p>
        </div>

    </div>


    {{-- ================= CONTENT ================= --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

        <div class="prose max-w-none text-gray-700 leading-relaxed">

            <p class="text-lg">
                {{-- Dinamis berdasarkan locale --}}
                {{ app()->getLocale() == 'en' ? ($information->description_en ?? $information->description) : $information->description }}
            </p>

        </div>


        {{-- ================= ACTION ================= --}}
        @if(auth()->id() == $information->creator_id || auth()->user()->role === 'admin') 

            <div class="mt-10 pt-6 border-t flex gap-3">

                <a href="{{ route('information.edit',$information->id) }}"
                class="px-5 py-2 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 transition font-medium">
                    ✏️ {{ __('announcements.edit') }}
                </a>

                <button
                onclick="openDeleteModal()"
                class="px-5 py-2 rounded-xl bg-red-500 hover:bg-red-600 text-white transition font-medium">
                    🗑 {{ __('announcements.delete') }}
                </button>

            </div>

        @endif

    </div>

</div>


{{-- ================= DELETE MODAL ================= --}}
<div id="deleteModal"
class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-[9999]">

    <div class="bg-white rounded-3xl shadow-xl p-8 max-w-sm w-full">

        <h2 class="text-xl font-bold mb-2 text-gray-800">
            {{ __('announcements.delete_confirm_title') }}
        </h2>

        <p class="text-sm text-gray-500 mb-6">
            {{ __('announcements.delete_confirm_msg') }}
        </p>

        <div class="flex justify-end gap-3">

            <button
            onclick="closeDeleteModal()"
            class="px-5 py-2 rounded-xl border text-gray-600 hover:bg-gray-100 transition font-medium">
                {{ __('announcements.btn_cancel') }}
            </button>

            <form action="{{ route('information.destroy',$information->id) }}"
            method="POST">
                @csrf
                @method('DELETE')

                <button
                class="px-5 py-2 rounded-xl bg-red-500 hover:bg-red-600 text-white transition font-bold">
                    {{ __('announcements.yes_delete') }}
                </button>
            </form>

        </div>

    </div>

</div>


{{-- ================= SCRIPT ================= --}}
<script>
    function openDeleteModal(){
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal(){
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Klik luar modal untuk menutup
    window.onclick = function(event) {
        const modal = document.getElementById('deleteModal');
        if (event.target == modal) {
            closeDeleteModal();
        }
    }
</script>

@endsection