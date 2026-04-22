@extends('layouts.library')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">

    {{-- BACK --}}
    <a href="{{ route('books.show',$book->id) }}"
    class="text-indigo-600 hover:underline font-medium">
        ← Back to Book
    </a>


    {{-- ================= BOOK HEADER ================= --}}
    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 
                rounded-3xl p-6 text-white shadow-lg flex items-center gap-6">

        <img 
        src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://placehold.co/100x140' }}"
        class="w-20 h-28 object-cover rounded-xl shadow">

        <div>
            <h1 class="text-2xl font-bold">
                {{ $book->title }}
            </h1>

            <p class="text-white/80 text-sm">
                by {{ $book->author }}
            </p>

            <p class="text-white/70 text-sm mt-1">
                {{ $reviews->total() }} reviews
            </p>
        </div>

    </div>


    {{-- ================= REVIEW LIST ================= --}}
    <div class="space-y-5">

        @forelse($reviews as $review)

        <div class="bg-white/80 backdrop-blur border border-white/40 
                    rounded-2xl p-5 shadow-sm hover:shadow-xl transition">

            <div class="flex justify-between items-center mb-2">

                <div>
                    <h3 class="font-semibold text-gray-800">
                        {{ $review->user->first_name }}
                    </h3>

                    <p class="text-xs text-gray-400">
                        {{ $review->created_at->diffForHumans() }}
                    </p>
                </div>

                {{-- RATING --}}
                <div class="text-yellow-500 text-sm">
                    {!! str_repeat('⭐',$review->rating) !!}
                </div>

            </div>

            {{-- COMMENT --}}
            <p class="text-gray-600 text-sm leading-relaxed">
                {{ $review->comment ?? 'No comment provided.' }}
            </p>

        </div>

        @empty

        <div class="text-center text-gray-400 py-10">
            No reviews yet 😢
        </div>

        @endforelse

    </div>


    {{-- ================= PAGINATION ================= --}}
    <div class="pt-4">
        {{ $reviews->links() }}
    </div>

</div>

@endsection