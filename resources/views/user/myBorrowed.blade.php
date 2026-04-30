@extends('layouts.library')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">

        <div>
            <a href="{{ route('dashboard') }}" 
               class="text-indigo-600 hover:underline font-medium text-sm flex items-center gap-1">
                ← {{ __('books.back_to_library') }}
            </a>
            <h1 class="text-3xl font-bold text-gray-800">
                {{ __('borrowed.my_borrowed_title') }}
            </h1>
            <p class="text-gray-500 text-sm">
                {{ __('borrowed.my_borrowed_subtitle') }}
            </p>
        </div>

        <a href="{{ route('borrowed.history') }}"
           class="bg-gray-100 hover:bg-gray-200 px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-700 transition flex items-center gap-2">
            🕘 {{ __('borrowed.view_history') }}
        </a>

    </div>


    {{-- ACTIVE BORROWED --}}
    <div class="space-y-4">

        @forelse($borrowed as $b)

            <a href="{{ route('borrowed.show',$b->id) }}" class="block group">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:border-indigo-200 hover:shadow-xl transition-all p-5 flex items-center gap-6">

                    {{-- COVER --}}
                    <img src="{{ $b->book->cover ? asset('storage/'.$b->book->cover) : 'https://placehold.co/80x110' }}"
                         class="w-16 h-24 object-cover rounded-lg shadow-sm group-hover:scale-105 transition-transform">

                    {{-- INFO --}}
                    <div class="flex-1">

                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-indigo-600 transition-colors">
                            {{ $b->book->title }}
                        </h3>

                        <p class="text-gray-500 text-sm">
                            {{ $b->book->author }}
                        </p>

                        <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                            📅 {{ __('borrowed.requested_at') }} {{ $b->created_at->format('d M Y') }}
                        </p>

                    </div>

                    {{-- STATUS BADGE --}}
                    <div class="flex items-center">

                        <span class="px-4 py-1.5 rounded-full text-xs font-bold shadow-sm
                            @if($b->status == 'requested')
                                bg-yellow-50 text-yellow-700 border border-yellow-200
                            @elseif($b->status == 'borrowed')
                                bg-blue-50 text-blue-700 border border-blue-200
                            @endif
                        ">

                            @if($b->status == 'requested') 
                                ⏳ {{ __('borrowed.status_requested') }} 
                            @elseif($b->status == 'borrowed') 
                                📖 {{ __('borrowed.status_borrowed') }} 
                            @endif

                        </span>

                    </div>

                </div>

            </a>

        @empty

            <div class="bg-white rounded-3xl shadow-sm border border-dashed border-gray-300 p-16 text-center">

                <div class="text-6xl mb-4">📚</div>

                <p class="text-gray-500 font-medium">
                    {{ __('borrowed.no_active_borrow') }}
                </p>
                
                <a href="{{ route('dashboard') }}" class="mt-4 inline-block text-indigo-600 font-semibold hover:underline">
                    {{ __('books.back_to_library') }} →
                </a>

            </div>

        @endforelse

    </div>

</div>

@endsection