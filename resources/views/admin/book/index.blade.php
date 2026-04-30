@extends('layouts.library')

@section('content')

<div class="px-4 sm:px-6 lg:px-10 space-y-8">

{{-- ================= HEADER ================= --}}
<div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-5 w-full">

    <div>
        <h1 class="text-2xl sm:text-3xl font-bold flex flex-wrap items-center gap-2">

            <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                {{ __('books.title') }}
            </span>

            <span class="text-gray-800">📚</span>

        </h1>

        <p class="text-gray-500 mt-1 text-sm sm:text-base">
            {{ __('books.subtitle') }}
        </p>
    </div>

    <div class="flex flex-col sm:flex-row gap-3 w-full xl:w-auto">

        {{-- SEARCH --}}
        <form method="GET" class="relative w-full sm:w-auto">
            <input
                name="search"
                value="{{ request('search') }}"
                placeholder="{{ __('books.search') }}"
                class="w-full sm:w-72 bg-white/80 backdrop-blur border border-white/50 px-4 py-2.5 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-400 outline-none transition"
            >
        </form>

        {{-- ADD BUTTON --}}
        <a href="{{ route('books.create') }}"
        class="text-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-5 py-2.5 rounded-xl shadow-md hover:scale-105 transition whitespace-nowrap">
            ➕ {{ __('books.add_book') }}
        </a>

    </div>

</div>

{{-- ================= DESKTOP TABLE ================= --}}
<div class="hidden lg:block w-full bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-white/40 overflow-hidden">

    <div class="overflow-x-auto">
        <table class="w-full table-auto text-sm">

            <thead class="bg-white/60 text-gray-500 text-xs uppercase tracking-wide">
            <tr>
                <th class="p-5 text-left">{{ __('books.table.book') }}</th>
                <th class="text-left">{{ __('books.table.author') }}</th>
                <th class="text-left">{{ __('books.table.stock') }}</th>
                <th class="text-left">{{ __('books.table.isbn') }}</th>
                <th class="text-center">{{ __('books.table.action') }}</th>
            </tr>
            </thead>

            <tbody>

            @forelse($books as $book)

            <tr
            onclick="window.location='{{ route('books.show',$book->id) }}'"
            class="group border-b border-white/40 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition duration-300 cursor-pointer">

                {{-- BOOK --}}
                <td class="p-5">
                    <div class="flex items-center gap-4">

                        <img
                        src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://via.placeholder.com/60x80' }}"
                        class="w-14 h-20 object-cover rounded-xl shadow-md">

                        <div>
                            <p class="font-semibold text-gray-800 group-hover:text-indigo-600 transition">
                                {{ $book->title }}
                            </p>

                            <p class="text-sm text-gray-400">
                                {{ $book->publisher }}
                            </p>
                        </div>

                    </div>
                </td>

                {{-- AUTHOR --}}
                <td class="text-gray-600 font-medium">
                    {{ $book->author }}
                </td>

                {{-- STOCK --}}
                <td>
                    @if($book->stock > 0)
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $book->stock }} {{ __('books.available') }}
                        </span>
                    @else
                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-semibold">
                            {{ __('books.out_of_stock') }}
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

                        <a href="{{ route('books.edit',$book->id) }}"
                        onclick="event.stopPropagation()"
                        class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-2 rounded-lg shadow transition">
                            ✏️
                        </a>

                        <button
                        type="button"
                        onclick="event.stopPropagation(); openDeleteModal('{{ route('books.destroy',$book->id) }}')"
                        class="px-3 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white shadow transition">
                            🗑
                        </button>

                    </div>
                </td>

            </tr>

            @empty

            <tr>
                <td colspan="5" class="text-center py-16 text-gray-400">
                    📭 {{ __('books.empty') }}
                </td>
            </tr>

            @endforelse

            </tbody>

        </table>
    </div>

</div>

{{-- ================= MOBILE CARD VIEW ================= --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:hidden">

@forelse($books as $book)

<div
onclick="window.location='{{ route('books.show',$book->id) }}'"
class="bg-white/80 backdrop-blur rounded-3xl border border-white/50 shadow-md p-4 cursor-pointer active:scale-[0.99] transition">

    <div class="flex gap-4">

        <img
        src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://via.placeholder.com/60x80' }}"
        class="w-20 h-28 object-cover rounded-2xl shadow">

        <div class="flex-1 min-w-0">

            <h3 class="font-semibold text-gray-800 line-clamp-2">
                {{ $book->title }}
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                {{ $book->author }}
            </p>

            <p class="text-xs text-gray-400 mt-1 truncate">
                {{ $book->publisher }}
            </p>

            <p class="text-xs text-gray-400 mt-2">
                ISBN: {{ $book->isbn }}
            </p>

            <div class="mt-3">
                @if($book->stock > 0)
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                        {{ $book->stock }} {{ __('books.available') }}
                    </span>
                @else
                    <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-semibold">
                        {{ __('books.out_of_stock') }}
                    </span>
                @endif
            </div>

        </div>

    </div>

    <div class="flex gap-2 mt-4">

        <a href="{{ route('books.edit',$book->id) }}"
        onclick="event.stopPropagation()"
        class="flex-1 text-center bg-indigo-500 hover:bg-indigo-600 text-white py-2 rounded-xl text-sm font-medium">
            ✏️ Edit
        </a>

        <button
        type="button"
        onclick="event.stopPropagation(); openDeleteModal('{{ route('books.destroy',$book->id) }}')"
        class="flex-1 bg-red-500 hover:bg-red-600 text-white py-2 rounded-xl text-sm font-medium">
            🗑 Delete
        </button>

    </div>

</div>

@empty

<div class="col-span-full text-center py-16 text-gray-400 bg-white rounded-3xl">
    📭 {{ __('books.empty') }}
</div>

@endforelse

</div>

{{-- PAGINATION --}}
<div class="p-2 sm:p-4">
    {{ $books->links() }}
</div>

</div>

{{-- ================= DELETE MODAL ================= --}}
<div id="deleteModal"
class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50 px-4">

<div class="bg-white/90 backdrop-blur rounded-2xl shadow-xl p-6 max-w-sm w-full text-center">

<h2 class="text-lg font-semibold mb-3 text-gray-800">
{{ __('books.delete_title') }}
</h2>

<p class="text-gray-500 mb-6 text-sm">
{{ __('books.delete_message') }}
</p>

<form id="deleteForm" method="POST">
    @csrf
    @method('DELETE')

    <button type="submit"
        class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white px-5 py-2.5 rounded-lg shadow">
        {{ __('books.yes_delete') }}
    </button>
</form>

<button
onclick="closeDeleteModal()"
class="mt-3 text-gray-500 text-sm hover:underline">
{{ __('books.cancel') }}
</button>

</div>

</div>

<script>
function openDeleteModal(actionUrl){
    const modal = document.getElementById('deleteModal');
    const form  = document.getElementById('deleteForm');

    form.setAttribute('action', actionUrl);

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteModal(){
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}
</script>

@endsection