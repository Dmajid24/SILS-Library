@extends('layouts.library')

@section('content')

<div class="space-y-8">

{{-- ================= HEADER ================= --}}
<div class="flex items-center justify-between">

    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Admin Dashboard
        </h1>

        <p class="text-gray-500 mt-1">
            Library analytics & management overview
        </p>
    </div>

    <div class="bg-white border px-4 py-2 rounded-xl text-sm shadow-sm">
        👋 Welcome, {{ auth()->user()->first_name }}
    </div>

</div>


{{-- ================= STATS ================= --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">

{{-- CARD --}}
<div class="bg-white border rounded-2xl p-6 shadow-sm">
    <p class="text-sm text-gray-500">Total Books</p>
    <p class="text-3xl font-bold text-gray-800 mt-2">
        {{ $booksCount }}
    </p>
</div>

<div class="bg-white border rounded-2xl p-6 shadow-sm">
    <p class="text-sm text-gray-500">Borrowed</p>
    <p class="text-3xl font-bold text-green-600 mt-2">
        {{ $borrowedCount }}
    </p>
</div>

<div class="bg-white border rounded-2xl p-6 shadow-sm">
    <p class="text-sm text-gray-500">Pending</p>
    <p class="text-3xl font-bold text-yellow-500 mt-2">
        {{ $pending }}
    </p>
</div>

<div class="bg-white border rounded-2xl p-6 shadow-sm">
    <p class="text-sm text-gray-500">Users</p>
    <p class="text-3xl font-bold text-purple-600 mt-2">
        {{ $usersCount }}
    </p>
</div>

</div>


{{-- ================= ANALYTICS ================= --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

{{-- CHART --}}
<div class="lg:col-span-2 bg-white border rounded-2xl p-6 shadow-sm">

    <h2 class="text-lg font-semibold text-gray-800 mb-4">
        Borrowing Analytics
    </h2>

    <canvas id="borrowChart"></canvas>

</div>


{{-- QUICK ACTION --}}
<div class="bg-white border rounded-2xl p-6 shadow-sm space-y-4">

    <h2 class="text-lg font-semibold text-gray-800">
        Quick Actions
    </h2>

    <a href="{{ route('books.index') }}"
       class="block w-full text-center bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition">
        📚 Manage Books
    </a>

    <a href="{{ route('admin.users.index') }}"
       class="block w-full text-center border border-purple-600 text-purple-600 py-2 rounded-lg hover:bg-purple-50 transition">
        👥 Manage Users
    </a>

    <a href="{{ route('admin.information.index') }}"
        class="block w-full text-center bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
        📢 Manage Information
    </a>

</div>

</div>


{{-- ================= BORROW REQUEST TABLE ================= --}}
<div class="bg-white border rounded-2xl p-6 shadow-sm">

<h2 class="text-lg font-semibold text-gray-800 mb-6">
Borrow Requests
</h2>


{{-- FILTER --}}
<div class="flex flex-wrap gap-3 mb-6">

<a href="{{ route('admin.dashboard') }}"
class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm">
All
</a>

<a href="{{ route('admin.dashboard',['status'=>'requested']) }}"
class="px-4 py-2 rounded-lg bg-yellow-50 text-yellow-700 hover:bg-yellow-100 text-sm">
Requested
</a>

<a href="{{ route('admin.dashboard',['status'=>'approved']) }}"
class="px-4 py-2 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 text-sm">
Approved
</a>

<a href="{{ route('admin.dashboard',['status'=>'borrowed']) }}"
class="px-4 py-2 rounded-lg bg-green-50 text-green-700 hover:bg-green-100 text-sm">
Borrowed
</a>

<a href="{{ route('admin.dashboard',['status'=>'rejected']) }}"
class="px-4 py-2 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 text-sm">
Rejected
</a>

</div>


{{-- TABLE --}}
<div class="overflow-x-auto">

<table class="w-full text-sm">

<thead class="border-b text-gray-500">
<tr>
<th class="py-3 text-left">User</th>
<th class="py-3 text-left">Book</th>
<th class="py-3 text-left">Date</th>
<th class="py-3 text-center">Status</th>
</tr>
</thead>

<tbody>

@forelse($borrowings as $r)

<tr class="border-b hover:bg-gray-50 cursor-pointer"
data-url="{{ route('admin.borrowings.show',$r->id) }}">

<td class="py-4 font-medium">
{{ $r->user->first_name }}
</td>

<td>{{ $r->book->title }}</td>

<td class="text-gray-500">
{{ \Carbon\Carbon::parse($r->request_date)->format('d M Y') }}
</td>

<td class="text-center">

@if($r->status == 'requested')
<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">Requested</span>

@elseif($r->status == 'approved')
<span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">Approved</span>

@elseif($r->status == 'borrowed')
<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">Borrowed</span>

@elseif($r->status == 'rejected')
<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">Rejected</span>

@elseif($r->status == 'returned')
<span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs">Returned</span>
@endif

</td>

</tr>

@empty

<tr>
<td colspan="4" class="text-center py-6 text-gray-400">
No borrowing requests
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>


{{-- ================= CHART SCRIPT ================= --}}
<script>

const ctx = document.getElementById('borrowChart');

if(ctx){

new Chart(ctx,{
type:'line',

data:{
labels:{!! json_encode(array_keys($monthlyBorrow->toArray())) !!},
datasets:[{
label:'Borrowings',
data:{!! json_encode(array_values($monthlyBorrow->toArray())) !!},
tension:0.4,
borderWidth:2
}]
},

options:{
responsive:true,
plugins:{
legend:{ display:true }
}
}
});

}

</script>


{{-- ROW CLICK --}}
<script>
document.querySelectorAll("tr[data-url]").forEach(row=>{
row.addEventListener("click",function(e){
if(e.target.closest("button") || e.target.closest("form")) return;
window.location.href=this.dataset.url;
});
});
</script>

@endsection