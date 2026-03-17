@extends('layouts.library')

@section('content')

<div class="max-w-3xl mx-auto space-y-6">

<h1 class="text-2xl font-bold">
Transaction Detail
</h1>

<div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-100">

<div class="flex justify-between items-start mb-6">

<div>
<h2 class="text-xl font-semibold">
{{ $borrow->book->title }}
</h2>

<p class="text-gray-500">
{{ $borrow->book->author }}
</p>
</div>

{{-- STATUS BADGE --}}
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


{{-- ACTION BUTTON --}}
@if($borrow->status == 'requested')

<div class="mt-8 border-t pt-6">

<form id="cancelForm" action="{{ route('borrow.cancel',$borrow->id) }}" method="POST">
@csrf
@method('DELETE')

<button type="button" onclick="openCancelModal()"
class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-xl shadow">
Cancel Request
</button>

</form>

</div>

@endif

</div>

</div>


{{-- CANCEL MODAL --}}
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