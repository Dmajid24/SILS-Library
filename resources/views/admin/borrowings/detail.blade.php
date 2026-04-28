@extends('layouts.library')

@section('content')

<div class="max-w-6xl mx-auto space-y-8">

{{-- HEADER --}}
<div>
    <h1 class="text-3xl font-bold text-slate-800">{{ __('Borrowing Detail') }}</h1>
    <p class="text-gray-500">{{ __('Transaction information & borrower data') }}</p>
</div>


<div class="grid lg:grid-cols-3 gap-8">

{{-- ================= BOOK INFO ================= --}}
<div class="lg:col-span-2 bg-white rounded-2xl shadow p-6">

<h2 class="text-lg font-semibold mb-4 text-gray-700">📚 {{ __('Book Information') }}</h2>

<div class="flex gap-6">

<img
src="{{ $borrowing->book->cover ? asset('storage/'.$borrowing->book->cover) : 'https://via.placeholder.com/60x80' }}"
class="w-28 h-40 object-cover rounded-lg shadow">

<div>
<h3 class="text-xl font-bold text-slate-800">
{{ $borrowing->book->title }}
</h3>

<p class="text-gray-600">
{{ $borrowing->book->author }}
</p>

<p class="text-gray-500 text-sm mt-2">
{{ Str::limit($borrowing->book->description,150) }}
</p>

</div>

</div>
</div>


{{-- ================= USER INFO ================= --}}
<div class="bg-white rounded-2xl shadow p-6">

<h2 class="text-lg font-semibold mb-4 text-gray-700">👤 {{ __('Borrower') }}</h2>

<p class="font-semibold text-slate-800">
{{ $borrowing->user->first_name }} {{ $borrowing->user->last_name }}
</p>

<p class="text-gray-500 text-sm">
{{ $borrowing->user->email }}
</p>

<p class="mt-3 text-sm">
<span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700">
{{ __(ucfirst($borrowing->user->role)) }}
</span>
</p>

@if($borrowing->user->role == 'lecturer' && $borrowing->user->lectureProfile)
<p class="mt-2 text-sm text-gray-500">
🎓 {{ $borrowing->user->lectureProfile->degree }}
</p>
@endif

</div>

</div>


{{-- ================= TRANSACTION INFO ================= --}}
<div class="bg-white rounded-2xl shadow p-6">

<h2 class="text-lg font-semibold mb-6 text-gray-700">📄 {{ __('Transaction') }}</h2>

<div class="grid md:grid-cols-4 gap-6 text-sm">

<div>
<p class="text-gray-400">{{ __('Requested') }}</p>
<p class="font-semibold">
{{ $borrowing->created_at->format('d M Y') }}
</p>
</div>

<div>
<p class="text-gray-400">{{ __('Status') }}</p>

<span class="
px-3 py-1 rounded-full text-xs font-semibold
@if($borrowing->status=='requested') bg-yellow-100 text-yellow-700
@elseif($borrowing->status=='approved') bg-blue-100 text-blue-700
@elseif($borrowing->status=='borrowed') bg-green-100 text-green-700
@elseif($borrowing->status=='returned') bg-gray-200 text-gray-700
@else bg-red-100 text-red-600
@endif
">
{{ __(ucfirst($borrowing->status)) }}
</span>

</div>

<div>
<p class="text-gray-400">{{ __('Due') }}</p>
<p class="font-semibold">
{{ $borrowing->due_date ? $borrowing->due_date->format('d M Y') : '-' }}
</p>
</div>

<div>
<p class="text-gray-400">{{ __('Returned') }}</p>
<p class="font-semibold">
{{ $borrowing->return_date ? $borrowing->return_date->format('d M Y') : '-' }}
</p>
</div>

</div>


{{-- ================= ACTION ================= --}}
<div class="mt-8 flex gap-3">

@if($borrowing->status == 'requested')

<button onclick="openApproveModal()"
class="px-5 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white transition">
{{ __('Approve') }}
</button>

<button onclick="openRejectModal()"
class="px-5 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white transition">
{{ __('Reject') }}
</button>

@elseif($borrowing->status == 'approved')

<button onclick="openBorrowedModal()"
class="px-5 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white">
{{ __('Mark as Borrowed') }}
</button>

@elseif($borrowing->status == 'borrowed')

<button onclick="openReturnedModal()"
class="px-5 py-2 rounded-lg bg-orange-600 hover:bg-orange-700 text-white">
{{ __('Mark as Returned') }}
</button>

@endif

</div>

</div>

</div>


{{-- ================= APPROVE MODAL ================= --}}
<div id="approveModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
<div class="bg-white p-6 rounded-xl text-center w-80">

<h2 class="font-semibold mb-3">{{ __('Approve Request') }}</h2>
<p class="text-sm text-gray-500 mb-5">{{ __('Confirm approve this borrowing?') }}</p>

<form method="POST" action="{{ url('/approve/'.$borrowing->id) }}">
@csrf

<button class="bg-green-600 text-white px-4 py-2 rounded-lg">
{{ __('Yes, Approve') }}
</button>

</form>

<button onclick="closeApproveModal()" class="mt-3 text-gray-500 text-sm">
{{ __('Cancel') }}
</button>

</div>
</div>


{{-- ================= REJECT MODAL ================= --}}
<div id="rejectModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
<div class="bg-white p-6 rounded-xl text-center w-80">

<h2 class="font-semibold mb-3">{{ __('Reject Request') }}</h2>
<p class="text-sm text-gray-500 mb-5">{{ __('Are you sure want to reject?') }}</p>

<form method="POST" action="{{ url('/reject/'.$borrowing->id) }}">
@csrf

<button class="bg-red-500 text-white px-4 py-2 rounded-lg">
{{ __('Yes, Reject') }}
</button>

</form>

<button onclick="closeRejectModal()" class="mt-3 text-gray-500 text-sm">
{{ __('Cancel') }}
</button>

</div>
</div>


{{-- ================= BORROWED MODAL ================= --}}
<div id="borrowedModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
<div class="bg-white p-6 rounded-xl text-center w-80">

<h2 class="font-semibold mb-3">{{ __('Mark as Borrowed') }}</h2>
<p class="text-sm text-gray-500 mb-5">{{ __('Confirm this book has been borrowed?') }}</p>

<form method="POST" action="{{ url('/borrowed/'.$borrowing->id) }}">
@csrf

<button class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
{{ __('Yes, Confirm') }}
</button>

</form>

<button onclick="closeBorrowedModal()" class="mt-3 text-gray-500 text-sm">
{{ __('Cancel') }}
</button>

</div>
</div>


{{-- ================= RETURNED MODAL ================= --}}
<div id="returnedModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
<div class="bg-white p-6 rounded-xl text-center w-80">

<h2 class="font-semibold mb-3">{{ __('Mark as Returned') }}</h2>
<p class="text-sm text-gray-500 mb-5">{{ __('Confirm this book has been returned?') }}</p>

<form method="POST" action="{{ url('/return/'.$borrowing->id) }}">
@csrf

<button class="bg-orange-600 text-white px-4 py-2 rounded-lg">
{{ __('Yes, Confirm') }}
</button>

</form>

<button onclick="closeReturnedModal()" class="mt-3 text-gray-500 text-sm">
{{ __('Cancel') }}
</button>

</div>
</div>


{{-- ================= SCRIPT ================= --}}
<script>
function openApproveModal(){
document.getElementById('approveModal').classList.remove('hidden');
document.getElementById('approveModal').classList.add('flex');
}

function closeApproveModal(){
document.getElementById('approveModal').classList.add('hidden');
}

function openRejectModal(){
document.getElementById('rejectModal').classList.remove('hidden');
document.getElementById('rejectModal').classList.add('flex');
}

function closeRejectModal(){
document.getElementById('rejectModal').classList.add('hidden');
}

function openBorrowedModal(){
document.getElementById('borrowedModal').classList.remove('hidden');
document.getElementById('borrowedModal').classList.add('flex');
}

function closeBorrowedModal(){
document.getElementById('borrowedModal').classList.add('hidden');
}

function openReturnedModal(){
document.getElementById('returnedModal').classList.remove('hidden');
document.getElementById('returnedModal').classList.add('flex');
}

function closeReturnedModal(){
document.getElementById('returnedModal').classList.add('hidden');
}
</script>

@endsection