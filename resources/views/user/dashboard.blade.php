@extends('layouts.library')

@section('content')

<!-- WELCOME CARD -->

<div class="relative bg-gradient-to-r from-slate-700 via-indigo-700 to-indigo-600 rounded-3xl p-8 text-white mb-10 shadow-xl overflow-hidden">

<!-- soft light decoration -->

<div class="absolute -right-20 -top-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>

<div class="absolute -left-10 bottom-0 w-52 h-52 bg-indigo-300/10 rounded-full blur-2xl"></div>


@if(Auth::user()->role == 'lecturer')

<h1 class="text-3xl font-semibold mb-2 tracking-wide">
Hello {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}, {{ Auth::user()->lectureProfile->degree }}
</h1>

@else

<h1 class="text-3xl font-semibold mb-2 tracking-wide">
Hello {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
</h1>

@endif

<p class="text-indigo-100 mb-6 max-w-lg">
Explore and borrow books from your school library collection.
</p>


<form method="GET">

<input
name="search"
value="{{ request('search') }}"
placeholder="Search books, authors, or ISBN..."
class="w-full md:w-96 px-5 py-3 rounded-xl text-gray-700 shadow-sm focus:ring-2 focus:ring-white outline-none"
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
href="{{ route('information.create') }}"
class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700 transition"
>
➕ Create Announcement
</a>
@endif

</div>



<!-- ANNOUNCEMENT LIST -->

<div class="grid md:grid-cols-3 gap-6 mb-12">

@foreach($info as $i)

<a href="{{ route('information.show',$i->id) }}">

<div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl transition hover:-translate-y-1 border border-gray-100">

<div class="flex items-center gap-3 mb-3">


<h3 class="font-semibold text-gray-800">
{{ $i->title }}
</h3>

</div>



<div class="mt-4 flex justify-between items-center">

<span class="text-xs text-gray-400">
{{ $i->created_at->format('d M Y') }}
</span>

<span class="text-indigo-600 text-sm font-medium">
Read →
</span>

</div>

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

@if($b->stock > 0)

<span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-medium">
{{ $b->stock }} Available
</span>

@else

<span class="bg-red-100 text-red-600 text-xs px-3 py-1 rounded-full font-medium">
Out of Stock
</span>

@endif

<a
href="{{ route('books.show',$b->id) }}"
class="text-indigo-600 text-sm font-semibold hover:underline"
>

Detail →

</a>

</div>

</div>

</div>

@endforeach

</div>

@endsection