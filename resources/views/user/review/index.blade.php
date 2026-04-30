@extends('layouts.library')

@section('content')

<div class="max-w-5xl mx-auto space-y-6 md:space-y-8">

    {{-- BACK BUTTON --}}
    <a href="{{ route('books.show', $book->id) }}"
       class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-semibold transition-colors group text-sm md:text-base">

        <span class="group-hover:-translate-x-1 transition-transform duration-200 mr-2">
        </span>

        <span>
            {{ __('books.back_to_book') }}
        </span>

    </a>



    {{-- ================= BOOK HEADER ================= --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500
                rounded-3xl md:rounded-[2rem] p-5 sm:p-6 md:p-8 text-white shadow-xl shadow-indigo-100">

        {{-- Background Decoration --}}
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-6 md:gap-8">

            <img
                src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://placehold.co/100x140' }}"
                alt="{{ $book->title }}"
                class="w-28 h-40 sm:w-32 sm:h-44 object-cover rounded-2xl shadow-2xl border-4 border-white/20 hover:scale-105 transition-transform duration-300 shrink-0">

            <div class="text-center md:text-left w-full">

                <h1 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight leading-tight mb-2">
                    {{ $book->title }}
                </h1>

                <p class="text-white/90 text-base md:text-lg font-medium leading-relaxed">
                    {{ __('books.by') }}
                    <span class="underline decoration-white/30">
                        {{ $book->author }}
                    </span>
                </p>

                <div class="inline-flex items-center mt-4 px-4 py-2 bg-white/20 backdrop-blur-md rounded-full text-sm font-bold">
                    ⭐ {{ __('books.reviews_count', ['count' => $reviews->total()]) }}
                </div>

            </div>

        </div>

    </div>



    {{-- ================= REVIEW LIST ================= --}}
    <div class="grid grid-cols-1 gap-5 md:gap-6">

        @forelse($reviews as $review)

        <div class="bg-white/70 backdrop-blur-xl border border-white/60
                    rounded-3xl md:rounded-[1.5rem] p-5 md:p-6 shadow-sm hover:shadow-md transition-all duration-300 group">

            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4 mb-4">

                {{-- USER --}}
                <div class="flex items-center gap-4 min-w-0">

                    {{-- Avatar --}}
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-100 to-purple-100 text-indigo-600 flex items-center justify-center font-bold text-lg shadow-inner shrink-0">
                        {{ strtoupper(substr($review->user->first_name, 0, 1)) }}
                    </div>

                    <div class="min-w-0">

                        <h3 class="font-bold text-gray-900 text-base truncate">
                            {{ $review->user->first_name }} {{ $review->user->last_name }}
                        </h3>

                        <p class="text-xs text-gray-400 font-medium mt-1">
                            {{ $review->created_at->diffForHumans() }}
                        </p>

                    </div>

                </div>

                {{-- RATING --}}
                <div class="flex gap-0.5 bg-yellow-50 px-3 py-1 rounded-lg shrink-0">

                    @for($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }} text-base">
                            ★
                        </span>
                    @endfor

                </div>

            </div>

            {{-- COMMENT --}}
            <div class="relative pl-4 border-l-4 border-indigo-50">

                <p class="text-gray-600 text-sm md:text-base leading-relaxed italic break-words">
                    "{{ $review->comment ?? __('books.no_comment') }}"
                </p>

            </div>

        </div>

        @empty

        {{-- EMPTY STATE --}}
        <div class="flex flex-col items-center justify-center py-16 md:py-20 bg-gray-50/50 rounded-3xl md:rounded-[2rem] border-2 border-dashed border-gray-200">

            <span class="text-5xl md:text-6xl mb-4">📚</span>

            <p class="text-gray-500 font-bold text-base md:text-lg text-center px-4">
                {{ __('books.no_reviews') }}
            </p>

        </div>

        @endforelse

    </div>



    {{-- ================= PAGINATION ================= --}}
    <div class="pt-2 md:pt-6 overflow-x-auto">
        {{ $reviews->links() }}
    </div>

</div>

@endsection