@extends('layouts.library')

@section('content')

<div class="space-y-10">

{{-- ================= HEADER ================= --}}
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            {{ __('dashboard.title') }}
        </h1>

        <p class="text-gray-500 mt-1">
            {{ __('dashboard.subtitle') }}
        </p>
    </div>

    <div class="flex items-center gap-3 bg-white/70 backdrop-blur border border-white/40 rounded-xl px-4 py-2 shadow">

        @if($school && $school->logo)
            <div class="bg-white p-1 rounded-lg shadow">
                <img src="{{ asset('storage/'.$school->logo) }}" class="w-8 h-8 object-contain">
            </div>
        @endif

        <div class="text-sm">
            <p class="font-medium text-gray-700">
                {{ $school->name ?? __('dashboard.school_default') }}
            </p>

            <p class="text-gray-400 text-xs">
                👋 {{ __('dashboard.welcome') }}, {{ auth()->user()->first_name }}
            </p>
        </div>

    </div>

</div>


{{-- ================= STATS ================= --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

    <div class="bg-white/70 backdrop-blur rounded-3xl border border-white/40 shadow-lg p-6">
        <p class="text-sm text-gray-500">{{ __('dashboard.stats.books') }}</p>
        <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $booksCount }}</p>
    </div>

    <div class="bg-white/70 backdrop-blur rounded-3xl border border-white/40 shadow-lg p-6">
        <p class="text-sm text-gray-500">{{ __('dashboard.stats.borrowed') }}</p>
        <p class="text-3xl font-bold text-purple-600 mt-2">{{ $borrowedCount }}</p>
    </div>

    <div class="bg-white/70 backdrop-blur rounded-3xl border border-white/40 shadow-lg p-6">
        <p class="text-sm text-gray-500">{{ __('dashboard.stats.pending') }}</p>
        <p class="text-3xl font-bold text-yellow-500 mt-2">{{ $pending }}</p>
    </div>

    <div class="bg-white/70 backdrop-blur rounded-3xl border border-white/40 shadow-lg p-6">
        <p class="text-sm text-gray-500">{{ __('dashboard.stats.users') }}</p>
        <p class="text-3xl font-bold text-pink-500 mt-2">{{ $usersCount }}</p>
    </div>

</div>


{{-- ================= ANALYTICS ================= --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

<div class="lg:col-span-2 bg-white/70 backdrop-blur border border-white/40 rounded-3xl p-6 shadow-lg">

    <h2 class="text-lg font-semibold text-gray-800 mb-4">
        {{ __('dashboard.analytics_title') }}
    </h2>

    <canvas id="borrowChart"></canvas>

</div>


{{-- QUICK ACTION --}}
<div class="bg-white/70 backdrop-blur border border-white/40 rounded-3xl p-6 shadow-lg space-y-4">

    <h2 class="text-lg font-semibold text-gray-800">
        {{ __('dashboard.quick_actions') }}
    </h2>

    <a href="{{ route('books.index') }}"
       class="block w-full text-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-2 rounded-xl font-semibold shadow">
        📚 {{ __('dashboard.actions.books') }}
    </a>

    <a href="{{ route('admin.users.index') }}"
       class="block w-full text-center border border-gray-200 py-2 rounded-xl">
        👥 {{ __('dashboard.actions.users') }}
    </a>

    <a href="{{ route('admin.information.index') }}"
       class="block w-full text-center border border-gray-200 py-2 rounded-xl">
        📢 {{ __('dashboard.actions.information') }}
    </a>

    <a href="{{ route('admin.school.edit') }}"
       class="block w-full text-center border border-gray-200 py-2 rounded-xl">
        🏫 {{ __('dashboard.actions.school') }}
    </a>

</div>

</div>


{{-- ================= BORROW REQUEST ================= --}}
<div class="bg-white/70 backdrop-blur border border-white/40 rounded-3xl p-6 shadow-lg">

<h2 class="text-lg font-semibold text-gray-800 mb-6">
    {{ __('dashboard.borrow_requests') }}
</h2>


{{-- FILTER --}}
<div class="flex flex-wrap gap-2 mb-6 text-sm">

<a href="{{ route('admin.dashboard') }}" class="px-3 py-1 rounded-lg bg-white shadow">
    {{ __('dashboard.filters.all') }}
</a>

<a href="{{ route('admin.dashboard',['status'=>'requested']) }}" class="px-3 py-1 rounded-lg bg-yellow-100 text-yellow-700">
    {{ __('dashboard.filters.requested') }}
</a>

<a href="{{ route('admin.dashboard',['status'=>'approved']) }}" class="px-3 py-1 rounded-lg bg-blue-100 text-blue-700">
    {{ __('dashboard.filters.approved') }}
</a>

<a href="{{ route('admin.dashboard',['status'=>'borrowed']) }}" class="px-3 py-1 rounded-lg bg-green-100 text-green-700">
    {{ __('dashboard.filters.borrowed') }}
</a>

<a href="{{ route('admin.dashboard',['status'=>'rejected']) }}" class="px-3 py-1 rounded-lg bg-red-100 text-red-700">
    {{ __('dashboard.filters.rejected') }}
</a>

</div>


{{-- TABLE --}}
<div class="overflow-x-auto">

<table class="w-full text-sm">

<thead class="border-b text-gray-400 text-xs uppercase">
<tr>
<th class="py-3 text-left">{{ __('dashboard.table.user') }}</th>
<th class="py-3 text-left">{{ __('dashboard.table.book') }}</th>
<th class="py-3 text-left">{{ __('dashboard.table.date') }}</th>
<th class="py-3 text-center">{{ __('dashboard.table.status') }}</th>
</tr>
</thead>

<tbody>

@forelse($borrowings as $r)

<tr class="border-b hover:bg-white/60">

<td class="py-4 font-medium text-gray-700">
    {{ $r->user->first_name }}
</td>

<td class="text-gray-600">
    {{ $r->book->title }}
</td>

<td class="text-gray-400">
    {{ \Carbon\Carbon::parse($r->request_date)->translatedFormat('d M Y') }}
</td>

<td class="text-center">
<span class="px-3 py-1 rounded-full text-xs">
    {{ __('dashboard.status.'.$r->status) }}
</span>
</td>

</tr>

@empty

<tr>
<td colspan="4" class="text-center py-6 text-gray-400">
    {{ __('dashboard.table.empty') }}
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

@endsection