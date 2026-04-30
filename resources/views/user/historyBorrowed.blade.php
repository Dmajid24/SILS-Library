@extends('layouts.library')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                {{ __('borrowed.history_title') }}
            </h1>

            <p class="text-gray-500 text-sm">
                {{ __('borrowed.history_subtitle') }}
            </p>
        </div>

        <a href="{{ route('borrowed.index') }}"
           class="bg-white border border-gray-200 hover:bg-gray-50 px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-700 shadow-sm transition flex items-center gap-2">
            📖 {{ __('borrowed.back_to_borrowed') }}
        </a>

    </div>


    {{-- HISTORY LIST --}}
    <div class="space-y-4">

        @forelse($history as $h)

            <a href="{{ route('borrowed.show', $h->id) }}" class="block group">

                <div class="bg-gray-50/50 rounded-2xl border border-gray-100 hover:bg-white hover:shadow-xl hover:border-transparent transition-all p-5 flex items-center gap-6">

                    {{-- COVER --}}
                    <div class="relative">
                        <img src="{{ $h->book->cover ? asset('storage/'.$h->book->cover) : 'https://placehold.co/80x110' }}"
                             class="w-16 h-24 object-cover rounded-lg grayscale group-hover:grayscale-0 transition-all duration-300 shadow-sm">
                        
                        <div class="absolute -top-2 -right-2 bg-green-500 text-white p-1 rounded-full shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    {{-- INFO --}}
                    <div class="flex-1">

                        <h3 class="text-lg font-bold text-gray-700 group-hover:text-indigo-600 transition-colors">
                            {{ $h->book->title }}
                        </h3>

                        <p class="text-gray-500 text-sm">
                            {{ $h->book->author }}
                        </p>

                        <p class="text-xs text-green-600 mt-2 font-medium flex items-center gap-1">
                            ✅ {{ __('borrowed.returned_at') }} 
                            {{ optional($h->return_date)->format('d M Y') ?? $h->updated_at->format('d M Y') }}
                        </p>

                    </div>

                    {{-- STATUS BADGE --}}
                    <div class="hidden sm:block">
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                            {{ __('borrowed.status_returned') }}
                        </span>
                    </div>

                </div>

            </a>

        @empty

            <div class="bg-white rounded-3xl shadow-sm border border-dashed border-gray-300 p-20 text-center">

                <div class="text-6xl mb-4">🕘</div>

                <p class="text-gray-500 font-medium">
                    {{ __('borrowed.no_history') }}
                </p>
                
                <a href="{{ route('dashboard') }}" class="mt-4 inline-block text-indigo-600 font-semibold hover:underline">
                    {{ __('books.back_to_library') }} →
                </a>

            </div>

        @endforelse

    </div>

</div>

@endsection