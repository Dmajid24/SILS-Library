@extends('layouts.library')

@section('content')

<div class="w-full space-y-8">

{{-- ================= HEADER ================= --}}
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

    <div>
        <h1 class="text-3xl font-bold flex items-center gap-2">
            <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                Import Preview
            </span>
            <span>📄</span>
        </h1>

        <p class="text-gray-500 mt-1">
            Validate uploaded CSV before importing users
        </p>
    </div>


</div>


{{-- ================= SUMMARY ================= --}}
@php
$ready = collect($rows)->where('status','Ready')->count();
$duplicate = collect($rows)->where('status','Duplicate')->count();
$invalid = collect($rows)->where('status','Invalid Row')->count();
@endphp

<div class="grid md:grid-cols-4 gap-5">

<div class="bg-white rounded-3xl shadow border p-6">
<p class="text-sm text-gray-500">Total Rows</p>
<h3 class="text-3xl font-bold text-gray-800 mt-2">{{ count($rows) }}</h3>
</div>

<div class="bg-white rounded-3xl shadow border p-6">
<p class="text-sm text-gray-500">Ready</p>
<h3 class="text-3xl font-bold text-green-600 mt-2">{{ $ready }}</h3>
</div>

<div class="bg-white rounded-3xl shadow border p-6">
<p class="text-sm text-gray-500">Duplicate</p>
<h3 class="text-3xl font-bold text-red-500 mt-2">{{ $duplicate }}</h3>
</div>

<div class="bg-white rounded-3xl shadow border p-6">
<p class="text-sm text-gray-500">Invalid</p>
<h3 class="text-3xl font-bold text-yellow-500 mt-2">{{ $invalid }}</h3>
</div>

</div>


{{-- ================= TABLE ================= --}}
<div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-white/40 overflow-hidden">

<div class="overflow-x-auto px-4">

<table class="w-full table-fixed text-sm">

<thead class="bg-white/60 text-gray-500 text-xs uppercase tracking-wider">
<tr>

<th class="w-16 px-6 py-4 text-left">No</th>

@if($role == 'student')
<th class="px-6 py-4 text-left">NIM</th>
<th class="px-6 py-4 text-left">Name</th>
<th class="px-6 py-4 text-left">Major</th>
<th class="px-6 py-4 text-left">Faculty</th>

@elseif($role == 'lecturer')
<th class="px-6 py-4 text-left">NIP</th>
<th class="px-6 py-4 text-left">Name</th>
<th class="px-6 py-4 text-left">Degree</th>
<th class="px-6 py-4 text-left">Department</th>

@elseif($role == 'staff')
<th class="px-6 py-4 text-left">Employee ID</th>
<th class="px-6 py-4 text-left">Name</th>
<th class="px-6 py-4 text-left">Job Position</th>
<th class="px-6 py-4 text-left">Department</th>
@endif

<th class="px-6 py-4 text-left">Status</th>
<th class="px-6 py-4 text-left">Message</th>

</tr>
</thead>

<tbody>

@foreach($rows as $i => $row)

<tr class="border-t hover:bg-white/60">

<td class="px-6 py-4">{{ $i+1 }}</td>
<td class="px-6 py-4">{{ $row['id_number'] }}</td>
<td class="px-6 py-4">{{ $row['name'] }}</td>
<td class="px-6 py-4">{{ $row['field1'] }}</td>
<td class="px-6 py-4">{{ $row['field2'] }}</td>

<td class="px-6 py-4">

@if($row['status']=='Ready')
<span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
Ready
</span>
@elseif($row['status']=='Duplicate')
<span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-700">
Duplicate
</span>
@else
<span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">
Invalid
</span>
@endif

</td>

<td class="px-6 py-4 text-gray-500">
{{ $row['message'] }}
</td>

</tr>

@endforeach

</tbody>
</table>

</div>

</div>


{{-- ================= FOOTER ACTION ================= --}}
<div class="flex justify-end gap-3">

<a href="{{ route('admin.users.index') }}"
class="px-5 py-2 border border-gray-300 text-gray-600 rounded-xl bg-white hover:bg-gray-50 transition">
Cancel
</a>

<form method="POST" action="{{ route('admin.users.import.confirm') }}">
@csrf

<button
class="px-5 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow-md hover:scale-105 transition flex items-center gap-2">
Confirm Import
</button>

</form>

</div>

</div>

@endsection