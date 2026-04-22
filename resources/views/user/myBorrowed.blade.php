@extends('layouts.library')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">

{{-- HEADER --}}
<div class="flex justify-between items-center">

<div>
    <a href="{{ route('dashboard') }}" 
        class="text-indigo-600 hover:underline font-medium">
        ← Back to Library
    </a>
<h1 class="text-3xl font-bold">
My Borrowed Books
</h1>

<p class="text-gray-500 text-sm">
Books you are currently borrowing
</p>
</div>

<a href="{{ route('borrowed.history') }}"
class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-xl text-sm font-medium transition">
🕘 View History
</a>

</div>


{{-- ACTIVE BORROWED --}}
<div class="space-y-4">

@forelse($borrowed as $b)

<a href="{{ route('borrowed.show',$b->id) }}">

<div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition p-5 flex items-center gap-6">

{{-- COVER --}}
<img
src="{{ $b->book->cover ? asset('storage/'.$b->book->cover) : 'https://placehold.co/80x110' }}"
class="w-16 h-24 object-cover rounded-lg shadow">

{{-- INFO --}}
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

{{-- STATUS BADGE --}}
<div class="flex items-center">

<span class="
px-3 py-1 rounded-full text-xs font-semibold

@if($b->status == 'requested')
bg-yellow-100 text-yellow-700
@elseif($b->status == 'borrowed')
bg-blue-100 text-blue-700
@endif
">

@if($b->status == 'requested') ⏳ @endif
@if($b->status == 'borrowed') 📖 @endif

{{ ucfirst($b->status) }}

</span>

</div>

</div>

</a>

@empty

<div class="bg-white rounded-3xl shadow p-10 text-center">

<div class="text-5xl mb-3">📚</div>

<p class="text-gray-500">
No active borrowings.
</p>

</div>

@endforelse

</div>

</div>

@endsection