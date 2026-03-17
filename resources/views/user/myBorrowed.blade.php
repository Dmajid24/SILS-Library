@extends('layouts.library')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">

<h1 class="text-3xl font-bold">
My Borrowed Books
</h1>

<div class="space-y-4">

@forelse($borrowed as $b)

<a href="{{ route('borrowed.show',$b->id) }}">

<div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition p-5 flex items-center gap-6">

{{-- BOOK COVER --}}
<img 
src="{{ $b->book->cover ? asset('storage/'.$b->book->cover) : 'https://placehold.co/80x110' }}"
class="w-16 h-24 object-cover rounded-lg shadow">

{{-- BOOK INFO --}}
<div class="flex-1">

<h3 class="text-lg font-semibold">
{{ $b->book->title }}
</h3>

<p class="text-gray-500 text-sm">
{{ $b->book->author }}
</p>

<p class="text-xs text-gray-400 mt-1">
Requested at {{ $b->created_at->format('d M Y') }}
</p>

</div>

{{-- STATUS --}}
<div>

<span class="px-4 py-1 rounded-full text-sm font-medium

@if($b->status == 'requested')
bg-yellow-100 text-yellow-700

@elseif($b->status == 'borrowed')
bg-blue-100 text-blue-700

@elseif($b->status == 'returned')
bg-green-100 text-green-700

@else
bg-red-100 text-red-700
@endif

">

{{ ucfirst($b->status) }}

</span>

</div>

</div>

</a>

@empty

{{-- EMPTY STATE --}}

<div class="bg-white rounded-3xl shadow p-10 text-center">

<div class="text-6xl mb-4">
📚
</div>

<h2 class="text-xl font-semibold mb-2">
No Borrow Requests Yet
</h2>

<p class="text-gray-500 mb-6">
You haven't requested any books from the library.
</p>

<a href="{{ route('dashboard') }}"
class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl shadow">

Browse Books

</a>

</div>

@endforelse

</div>

</div>

@endsection