@extends('layouts.library')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">
<a href="{{ route('borrowed.index') }}" 
class="text-indigo-600 hover:underline font-medium">
← Back
</a>
<h1 class="text-3xl font-bold text-gray-800">
📖 Borrowing Detail
</h1>


<div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">

<div class="grid md:grid-cols-3 gap-10">

{{-- ================================= --}}
{{-- BOOK COVER --}}
{{-- ================================= --}}
<div class="flex flex-col items-center">

<img
src="{{ $borrow->book->cover ? asset('storage/'.$borrow->book->cover) : 'https://placehold.co/220x320' }}"
class="w-52 h-72 object-cover rounded-2xl shadow-lg">

{{-- STATUS BADGE --}}
<div class="mt-5">

@if($borrow->status == 'requested')
<span class="bg-yellow-100 text-yellow-700 px-4 py-1 rounded-full text-sm font-semibold">
🕐 Requested
</span>

@elseif($borrow->status == 'borrowed')
<span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm font-semibold">
📚 Borrowed
</span>

@elseif($borrow->status == 'returned')
<span class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm font-semibold">
✔ Returned
</span>
@endif

</div>

</div>


{{-- ================================= --}}
{{-- BOOK DETAIL --}}
{{-- ================================= --}}
<div class="md:col-span-2 space-y-6">

<div>
<h2 class="text-2xl font-semibold text-gray-800">
{{ $borrow->book->title }}
</h2>

<p class="text-gray-500">
by {{ $borrow->book->author }}
</p>
</div>


{{-- BORROW INFO --}}
<div class="grid grid-cols-2 gap-4 text-sm">

<div class="bg-gradient-to-br from-indigo-50 to-white p-4 rounded-xl border">
<p class="text-gray-500">Borrow Date</p>
<p class="font-semibold text-gray-800">
{{ $borrow->borrow_date ?? '-' }}
</p>
</div>

<div class="bg-gradient-to-br from-purple-50 to-white p-4 rounded-xl border">
<p class="text-gray-500">Return Date</p>
<p class="font-semibold text-gray-800">
{{ $borrow->return_date ?? '-' }}
</p>
</div>

</div>


{{-- ================================= --}}
{{-- BORROW TIMELINE --}}
{{-- ================================= --}}
<div>

<h3 class="font-semibold mb-4 text-gray-800">
📅 Borrow Timeline
</h3>

<div class="space-y-4 text-sm">

<div class="flex items-start gap-3">
<div class="w-3 h-3 mt-1 rounded-full bg-yellow-400"></div>
<p>
Request submitted — 
<span class="font-medium">
{{ $borrow->created_at->format('d M Y') }}
</span>
</p>
</div>

@if($borrow->status == 'borrowed' || $borrow->status == 'returned')
<div class="flex items-start gap-3">
<div class="w-3 h-3 mt-1 rounded-full bg-blue-500"></div>
<p class="font-medium">
Book borrowed
</p>
</div>
@endif

@if($borrow->status == 'returned')
<div class="flex items-start gap-3">
<div class="w-3 h-3 mt-1 rounded-full bg-green-500"></div>
<p>
Book returned — 
<span class="font-medium">
{{ $borrow->return_date ?? '-' }}
</span>
</p>
</div>
@endif

</div>

</div>


{{-- ================================= --}}
{{-- ACTION BUTTON --}}
{{-- ================================= --}}
@if($borrow->status == 'requested' || $borrow->status == 'approved')

<div class="border-t pt-6">

<form id="cancelForm" action="{{ route('borrow.cancel',$borrow->id) }}" method="POST">
@csrf
@method('DELETE')

<button type="button"
onclick="cancelModal.open()"
class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-xl shadow transition">
❌ Cancel Request
</button>

</form>

</div>

@endif

</div>

</div>

</div>

</div>



{{-- ================================= --}}
{{-- CANCEL MODAL (UPGRADE) --}}
{{-- ================================= --}}
<div id="cancelModal"
class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-[999]">

<div id="cancelContent"
class="bg-white rounded-3xl shadow-2xl p-8 max-w-sm w-full text-center
transform scale-95 opacity-0 transition duration-300">

<div class="text-4xl mb-3">⚠️</div>

<h2 class="text-xl font-semibold mb-2 text-gray-800">
Cancel Borrow Request
</h2>

<p class="text-gray-500 mb-6">
Are you sure you want to cancel this request?
</p>

<div class="flex justify-center gap-3">

<button onclick="cancelModal.submit()"
class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl shadow">
Yes, Cancel
</button>

<button onclick="cancelModal.close()"
class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-xl">
Keep Request
</button>

</div>

</div>

</div>


<script>

const cancelModal = {

modal: document.getElementById('cancelModal'),
content: document.getElementById('cancelContent'),

open(){
this.modal.classList.remove('hidden');
this.modal.classList.add('flex');

setTimeout(()=>{
this.content.classList.remove('scale-95','opacity-0');
this.content.classList.add('scale-100','opacity-100');
},10);
},

close(){
this.content.classList.remove('scale-100','opacity-100');
this.content.classList.add('scale-95','opacity-0');

setTimeout(()=>{
this.modal.classList.add('hidden');
this.modal.classList.remove('flex');
},200);
},

submit(){
document.getElementById('cancelForm').submit();
}

};


// klik luar modal
cancelModal.modal.addEventListener('click', function(e){
if(e.target === this){
cancelModal.close();
}
});

</script>

@endsection