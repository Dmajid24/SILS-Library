@extends('layouts.library')

@section('content')

<div class="max-w-7xl mx-auto space-y-10">

{{-- ================= HEADER ================= --}}
<div class="flex justify-between items-center">

    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            📢 Manage Announcements
        </h1>

        <p class="text-gray-500">
            Create and manage library announcements
        </p>
    </div>

    <a href="{{ route('information.create') }}"
       class="bg-indigo-600 text-white px-5 py-2 rounded-lg
              hover:bg-indigo-700 transition shadow">
        + Create Announcement
    </a>

</div>


{{-- ================= YOUR ANNOUNCEMENTS ================= --}}
@if($yourInfo->count())

<div>
    <h2 class="text-xl font-semibold text-gray-800 mb-4">
        ⭐ Your Announcements
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($yourInfo as $i)

        <a href="{{ route('information.show',$i->id) }}" class="block">

            <div class="bg-white border rounded-2xl shadow-sm overflow-hidden
                        hover:shadow-md transition hover:-translate-y-1">

                {{-- IMAGE --}}
                <img
                src="{{ $i->image_content ? asset('storage/'.$i->image_content) : 'https://via.placeholder.com/400x200' }}"
                class="w-full h-44 object-cover">

                {{-- CONTENT --}}
                <div class="p-5 space-y-3">

                    <div class="flex justify-between items-center">
                        <h2 class="font-semibold text-gray-800 text-lg">
                            {{ $i->title }}
                        </h2>

                        {{-- BADGE YOU --}}
                        <span class="text-xs bg-indigo-100 text-indigo-600 px-2 py-1 rounded">
                            You
                        </span>
                    </div>

                    <p class="text-sm text-gray-500">
                        {{ Str::limit($i->description,100) }}
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

    <h2 class="text-xl font-semibold text-gray-800 mb-4">
        📚 Other Announcements
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse($info as $i)

        <a href="{{ route('information.show',$i->id) }}" class="block">

            <div class="bg-white border rounded-2xl shadow-sm overflow-hidden
                        hover:shadow-md transition hover:-translate-y-1">

                {{-- IMAGE --}}
                <img
                src="{{ $i->image_content ? asset('storage/'.$i->image_content) : 'https://via.placeholder.com/400x200' }}"
                class="w-full h-44 object-cover">

                {{-- CONTENT --}}
                <div class="p-5 space-y-3">

                    <h2 class="font-semibold text-gray-800 text-lg">
                        {{ $i->title }}
                    </h2>

                    <p class="text-sm text-gray-500">
                        {{ Str::limit($i->description,100) }}
                    </p>

                    <p class="text-xs text-gray-400">
                        {{ $i->created_at->format('d M Y') }}
                    </p>

                </div>

            </div>

        </a>

        @empty

        <div class="col-span-3 text-center py-20 text-gray-400">
            No announcements yet
        </div>

        @endforelse

    </div>

</div>

</div>

@endsection