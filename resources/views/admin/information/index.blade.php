@extends('layouts.library')

@section('content')

<div class="max-w-7xl mx-auto space-y-10">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold flex items-center gap-2">
                <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                    {{ __('announcements.title') }}
                </span>
                📢
            </h1>
            <p class="text-gray-500 mt-1">
                {{ __('announcements.subtitle') }}
            </p>
        </div>

        <a href="{{ route('information.create') }}"
           class="px-6 py-2 rounded-xl text-white 
                  bg-gradient-to-r from-indigo-600 to-purple-600
                  shadow-md hover:scale-105 transition font-medium">
            + {{ __('announcements.create_btn') }}
        </a>
    </div>

    {{-- ================= YOUR ANNOUNCEMENTS ================= --}}
    @if($yourInfo->count())
    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
            ⭐ {{ __('announcements.your_announcements') }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($yourInfo as $i)
            <a href="{{ route('information.show', $i->id) }}" class="block group">
                <div class="bg-white/80 backdrop-blur-xl border border-white/40 
                            rounded-3xl shadow-lg overflow-hidden
                            transition transform group-hover:-translate-y-1 group-hover:shadow-xl h-full">

                    <div class="overflow-hidden">
                        <img src="{{ $i->image_content ? asset('storage/'.$i->image_content) : 'https://via.placeholder.com/400x200' }}"
                             class="w-full h-44 object-cover group-hover:scale-105 transition duration-300">
                    </div>

                    <div class="p-5 space-y-3">
                        <div class="flex justify-between items-start gap-2">
                            <h2 class="font-semibold text-gray-800 text-lg leading-tight">
                                {{ $i->title }}
                            </h2>
                            <span class="text-xs bg-indigo-100 text-indigo-600 px-2 py-1 rounded-lg shrink-0 font-medium">
                                {{ __('announcements.you') }}
                            </span>
                        </div>

                        <p class="text-sm text-gray-500">
                            {{ Str::limit($i->description, 100) }}
                        </p>

                        <p class="text-xs text-gray-400">
                            {{ $i->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ================= OTHER ANNOUNCEMENTS ================= --}}
    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
            📚 {{ __('announcements.other_announcements') }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($info as $i)
            <a href="{{ route('information.show', $i->id) }}" class="block group">
                <div class="bg-white/80 backdrop-blur-xl border border-white/40 
                            rounded-3xl shadow-lg overflow-hidden
                            transition transform group-hover:-translate-y-1 group-hover:shadow-xl h-full">

                    <div class="overflow-hidden">
                        <img src="{{ $i->image_content ? asset('storage/'.$i->image_content) : 'https://via.placeholder.com/400x200' }}"
                             class="w-full h-44 object-cover group-hover:scale-105 transition duration-300">
                    </div>

                    <div class="p-5 space-y-3">
                        <h2 class="font-semibold text-gray-800 text-lg leading-tight">
                            {{ $i->title }}
                        </h2>
                        <p class="text-sm text-gray-500">
                            {{ Str::limit($i->description, 100) }}
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ $i->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </a>
            @empty
            {{-- EMPTY STATE --}}
            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 bg-white/50 rounded-3xl border border-dashed border-gray-300">
                <div class="text-6xl mb-4">📭</div>
                <p class="text-gray-500 mb-6 font-medium">
                    {{ __('announcements.no_announcements') }}
                </p>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection