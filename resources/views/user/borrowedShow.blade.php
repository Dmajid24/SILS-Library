@extends('layouts.library')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">

<h1 class="text-2xl font-bold">
Borrowing Detail
</h1>


<div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8">

<div class="grid md:grid-cols-3 gap-8">

{{-- ================================= --}}
{{-- BOOK COVER --}}
{{-- ================================= --}}
<div class="flex flex-col items-center">

<img
src="{{ $borrow->book->cover ? asset('storage/'.$borrow->book->cover) : 'https://placehold.co/220x320' }}"
class="w-52 h-72 object-cover rounded-2xl shadow-lg">

{{-- STATUS BADGE --}}
<div class="mt-4">

@if($borrow->status == 'requested')
<span class="bg-yellow-100 text-yellow-700 px-4 py-1 rounded-full text-sm font-medium">
Requested
</span>

@elseif($borrow->status == 'borrowed')
<span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm font-medium">
Borrowed
</span>

@elseif($borrow->status == 'returned')
<span class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm font-medium">
Returned
</span>
@endif

</div>

</div>


{{-- ================================= --}}
{{-- BOOK DETAIL --}}
{{-- ================================= --}}
<div class="md:col-span-2 space-y-6">

<div>
<h2 class="text-2xl font-semibold">
{{ $borrow->book->title }}
</h2>

<p class="text-gray-500">
by {{ $borrow->book->author }}
</p>
</div>


{{-- BORROW INFO --}}
<div class="grid grid-cols-2 gap-4 text-sm">

<div class="bg-gray-50 p-4 rounded-xl">
<p class="text-gray-500">Borrow Date</p>
<p class="font-semibold">
{{ $borrow->borrow_date ?? '-' }}
</p>
</div>

<div class="bg-gray-50 p-4 rounded-xl">
<p class="text-gray-500">Return Date</p>
<p class="font-semibold">
{{ $borrow->return_date ?? '-' }}
</p>
</div>

</div>


{{-- ================================= --}}
{{-- BORROW TIMELINE --}}
{{-- ================================= --}}
<div>

<h3 class="font-semibold mb-3">
Borrow Timeline
</h3>

<div class="space-y-3 text-sm">

<div class="flex items-center gap-3">
<div class="w-3 h-3 rounded-full bg-yellow-400"></div>
<p>Request submitted — {{ $borrow->created_at->format('d M Y') }}</p>
</div>

@if($borrow->status == 'borrowed' || $borrow->status == 'returned')
<div class="flex items-center gap-3">
<div class="w-3 h-3 rounded-full bg-blue-500"></div>
<p>Book borrowed</p>
</div>
@endif

@if($borrow->status == 'returned')
<div class="flex items-center gap-3">
<div class="w-3 h-3 rounded-full bg-green-500"></div>
<p>Book returned — {{ $borrow->return_date ?? '-' }}</p>
</div>
@endif

</div>

</div>


{{-- ================================= --}}
{{-- ACTION BUTTON --}}
{{-- ================================= --}}
@if($borrow->status == 'requested'||$borrow->status == 'approved')

<div class="border-t pt-6">

<form id="cancelForm" action="{{ route('borrow.cancel',$borrow->id) }}" method="POST">
@csrf
@method('DELETE')

<button type="button"
onclick="openCancelModal()"
class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-xl shadow">
Cancel Request
</button>

</form>

</div>

@endif

</div>

</div>

</div>

</div>



{{-- ================================= --}}
{{-- CANCEL MODAL --}}
{{-- ================================= --}}
<div id="cancelModal"
class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

<div class="bg-white rounded-2xl p-8 max-w-sm w-full text-center">

<h2 class="text-lg font-semibold mb-3">
Cancel Borrow Request
</h2>

<p class="text-gray-500 mb-6">
Are you sure you want to cancel this request?
</p>

<div class="flex justify-center gap-4">

<button onclick="submitCancel()"
class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg">
Yes, Cancel
</button>

<button onclick="closeCancelModal()"
class="bg-gray-200 hover:bg-gray-300 px-5 py-2 rounded-lg">
No
</button>

</div>

</div>

</div>


<script>

function openCancelModal(){
document.getElementById('cancelModal').classList.remove('hidden');
document.getElementById('cancelModal').classList.add('flex');
}

function closeCancelModal(){
document.getElementById('cancelModal').classList.add('hidden');
}

function submitCancel(){
document.getElementById('cancelForm').submit();
}

</script>

@endsection