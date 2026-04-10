@extends('layouts.library')

@section('content')

<!-- WELCOME CARD -->

<div class="bg-gradient-to-r from-slate-800 via-indigo-800 to-slate-700 rounded-3xl p-8 text-white mb-10 shadow-lg">

    @if(Auth::user()->role == 'lecturer')

        <h1 class="text-3xl font-bold mb-2">
            Hello {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}, {{ Auth::user()->lectureProfile->degree }}
        </h1>

    @else

        <h1 class="text-3xl font-bold mb-2">
            Hello {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
        </h1>

    @endif

    <p class="text-gray-200 mb-6">
        Find and borrow books from your school library
    </p>

    <form method="GET">
        <input
            name="search"
            value="{{ request('search') }}"
            placeholder="Search books or authors..."
            class="w-full md:w-96 px-5 py-3 rounded-xl text-gray-700 focus:ring-2 focus:ring-indigo-500 outline-none"
        />
    </form>

</div>


<!-- ANNOUNCEMENT HEADER -->

<div class="flex justify-between items-center mb-6">

    <h2 class="text-xl font-semibold text-gray-800">
        📢 Library Events
    </h2>

    @if(auth()->user()->role === 'lecturer')
        <a
            href="{{ route('admin.information.index') }}"
            class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700 transition"
        >
            📢 Manage Announcement
        </a>
    @endif

</div>


<!-- ANNOUNCEMENT LIST -->

<div class="grid md:grid-cols-3 gap-6 mb-12">

@foreach($info as $i)

<a href="{{ route('information.show',$i->id) }}">

<div class="bg-white border border-gray-200 p-6 rounded-2xl shadow hover:shadow-lg transition hover:-translate-y-1">

<h3 class="font-semibold text-lg mb-2 text-gray-800">
{{ $i->title }}
</h3>

<p class="text-xs mt-3 text-indigo-600 font-medium">
See Details →
</p>

</div>

</a>

@endforeach

</div>


<!-- BOOK SECTION -->

<h2 class="text-xl font-semibold mb-6 text-gray-800">
Explore Books
</h2>

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

@foreach($book as $b)

<div class="bg-white rounded-3xl overflow-hidden shadow hover:shadow-xl transition transform hover:-translate-y-1">

<img
src="{{ $b->cover ? asset('storage/'.$b->cover) : 'https://placehold.co/300x400' }}"
class="w-full h-56 object-cover">

<div class="p-5">

<h3 class="font-semibold text-gray-800 text-lg">
{{ $b->title }}
</h3>

<p class="text-sm text-gray-500 mt-1">
{{ $b->author }}
</p>

<div class="flex justify-between items-center mt-4">

<span class="text-green-600 text-sm font-medium">
{{ $b->stock }} available
</span>

<a
href="{{ route('books.show',$b->id) }}"
class="text-indigo-600 text-sm font-semibold hover:underline">

Detail →

</a>

</div>

</div>

</div>  

@endforeach

</div>

@endsection