@extends('layouts.library')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">

{{-- HEADER --}}
<div class="flex justify-between items-center">

<div>
<h1 class="text-3xl font-bold">
Borrow History
</h1>

<p class="text-gray-500 text-sm">
Books you have returned
</p>
</div>

<a href="{{ route('borrowed.index') }}"
class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-xl text-sm font-medium transition">
📖 Back to Borrowed
</a>

</div>


{{-- HISTORY LIST --}}
<div class="space-y-4">

@forelse($history as $h)

<a href="{{ route('borrowed.show',$h->id) }}">

<div class="bg-gray-50 rounded-2xl shadow-sm hover:shadow-md transition p-5 flex items-center gap-6">

{{-- COVER --}}
<img
src="{{ $h->book->cover ? asset('storage/'.$h->book->cover) : 'https://placehold.co/80x110' }}"
class="w-16 h-24 object-cover rounded-lg opacity-80">

{{-- INFO --}}
<div class="flex-1">

<h3 class="text-lg font-semibold text-gray-700">
{{ $h->book->title }}
</h3>

<p class="text-gray-500 text-sm">
{{ $h->book->author }}
</p>

<p class="text-xs text-green-600 mt-1">
Returned at
{{ optional($h->return_date)->format('d M Y') ?? $h->updated_at->format('d M Y') }}
</p>

</div>

{{-- STATUS --}}
<div>

<span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
✔ Returned
</span>

</div>

</div>

</a>

@empty

<div class="bg-white rounded-3xl shadow p-10 text-center">

<div class="text-5xl mb-3">🕘</div>

<p class="text-gray-500">
No borrowing history yet.
</p>

</div>

@endforelse

</div>

</div>

@endsection