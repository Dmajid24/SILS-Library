@extends('layouts.library')

@section('content')

<div class="space-y-8 sm:space-y-10">

{{-- ================= HEADER ================= --}}
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">
            {{ __('dashboard.title') }}
        </h1>

        <p class="text-sm sm:text-base text-gray-500 mt-1">
            {{ __('dashboard.subtitle') }}
        </p>
    </div>

    <div class="flex items-center gap-3 bg-white/70 backdrop-blur border border-white/40 rounded-2xl px-4 py-3 shadow w-full sm:w-auto">

        @if($school && $school->logo)
            <div class="bg-white p-1 rounded-lg shadow shrink-0">
                <img src="{{ asset('storage/'.$school->logo) }}" class="w-8 h-8 object-contain">
            </div>
        @endif

        <div class="text-sm min-w-0">
            <p class="font-medium text-gray-700 truncate">
                {{ $school->name ?? __('dashboard.school_default') }}
            </p>

            <p class="text-gray-400 text-xs truncate">
                👋 {{ __('dashboard.welcome') }}, {{ auth()->user()->first_name }}
            </p>
        </div>

    </div>

</div>



{{-- ================= STATS ================= --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">

    <div class="bg-white/70 backdrop-blur rounded-3xl border border-white/40 shadow-lg p-4 sm:p-6">
        <p class="text-xs sm:text-sm text-gray-500">{{ __('dashboard.stats.books') }}</p>
        <p class="text-2xl sm:text-3xl font-bold text-indigo-600 mt-2">{{ $booksCount }}</p>
    </div>

    <div class="bg-white/70 backdrop-blur rounded-3xl border border-white/40 shadow-lg p-4 sm:p-6">
        <p class="text-xs sm:text-sm text-gray-500">{{ __('dashboard.stats.borrowed') }}</p>
        <p class="text-2xl sm:text-3xl font-bold text-purple-600 mt-2">{{ $borrowedCount }}</p>
    </div>

    <div class="bg-white/70 backdrop-blur rounded-3xl border border-white/40 shadow-lg p-4 sm:p-6">
        <p class="text-xs sm:text-sm text-gray-500">{{ __('dashboard.stats.pending') }}</p>
        <p class="text-2xl sm:text-3xl font-bold text-yellow-500 mt-2">{{ $pending }}</p>
    </div>

    <div class="bg-white/70 backdrop-blur rounded-3xl border border-white/40 shadow-lg p-4 sm:p-6">
        <p class="text-xs sm:text-sm text-gray-500">{{ __('dashboard.stats.users') }}</p>
        <p class="text-2xl sm:text-3xl font-bold text-pink-500 mt-2">{{ $usersCount }}</p>
    </div>

</div>



{{-- ================= REVIEW SUMMARY ================= --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">

    <div class="bg-white/70 backdrop-blur rounded-3xl border border-white/40 shadow-lg p-4 sm:p-6">
        <p class="text-sm text-gray-500">{{ __('dashboard.review.total') }}</p>
        <p class="text-2xl sm:text-3xl font-bold text-yellow-500 mt-2">{{ $reviewsCount }}</p>
    </div>

    <div class="bg-white/70 backdrop-blur rounded-3xl border border-white/40 shadow-lg p-4 sm:p-6">
        <p class="text-sm text-gray-500">{{ __('dashboard.review.today') }}</p>
        <p class="text-2xl sm:text-3xl font-bold text-green-500 mt-2">{{ $todayReviews }}</p>
    </div>

    <div class="bg-white/70 backdrop-blur rounded-3xl border border-white/40 shadow-lg p-4 sm:p-6">
        <p class="text-sm text-gray-500">{{ __('dashboard.review.low') }}</p>
        <p class="text-2xl sm:text-3xl font-bold text-red-500 mt-2">{{ $lowReviews }}</p>
    </div>

</div>



{{-- ================= ANALYTICS ================= --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    <div class="xl:col-span-2 bg-white/70 backdrop-blur border border-white/40 rounded-3xl p-4 sm:p-6 shadow-lg">

        <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">
            {{ __('dashboard.analytics_title') }}
        </h2>

        <div class="h-72 sm:h-80">
            <canvas id="borrowChart"></canvas>
        </div>

    </div>



    {{-- QUICK ACTION --}}
    <div class="bg-white/70 backdrop-blur border border-white/40 rounded-3xl p-4 sm:p-6 shadow-lg space-y-4">

        <h2 class="text-base sm:text-lg font-semibold text-gray-800">
            {{ __('dashboard.quick_actions') }}
        </h2>

        <a href="{{ route('books.index') }}"
           class="block w-full text-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-xl font-semibold shadow hover:scale-[1.02] transition">
            📚 {{ __('dashboard.actions.books') }}
        </a>

        <a href="{{ route('admin.users.index') }}"
           class="block w-full text-center border border-gray-200 py-3 rounded-xl hover:bg-gray-50 transition">
            👥 {{ __('dashboard.actions.users') }}
        </a>

        <a href="{{ route('admin.information.index') }}"
           class="block w-full text-center border border-gray-200 py-3 rounded-xl hover:bg-gray-50 transition">
            📢 {{ __('dashboard.actions.information') }}
        </a>

        <a href="{{ route('admin.school.edit') }}"
           class="block w-full text-center border border-gray-200 py-3 rounded-xl hover:bg-gray-50 transition">
            🏫 {{ __('dashboard.actions.school') }}
        </a>

    </div>

</div>



{{-- ================= BORROW REQUEST ================= --}}
<div class="bg-white/70 backdrop-blur border border-white/40 rounded-3xl p-4 sm:p-6 shadow-lg">

    <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-6">
        {{ __('dashboard.borrow_requests') }}
    </h2>



    {{-- FILTER --}}
    <div class="flex gap-2 mb-6 overflow-x-auto pb-2 text-sm">

        <a href="{{ route('admin.dashboard') }}"
           class="px-4 py-2 rounded-xl bg-white shadow whitespace-nowrap hover:bg-gray-50">
            {{ __('dashboard.filters.all') }}
        </a>

        <a href="{{ route('admin.dashboard',['status'=>'requested']) }}"
           class="px-4 py-2 rounded-xl bg-yellow-100 text-yellow-700 whitespace-nowrap">
            {{ __('dashboard.filters.requested') }}
        </a>

        <a href="{{ route('admin.dashboard',['status'=>'approved']) }}"
           class="px-4 py-2 rounded-xl bg-blue-100 text-blue-700 whitespace-nowrap">
            {{ __('dashboard.filters.approved') }}
        </a>

        <a href="{{ route('admin.dashboard',['status'=>'borrowed']) }}"
           class="px-4 py-2 rounded-xl bg-green-100 text-green-700 whitespace-nowrap">
            {{ __('dashboard.filters.borrowed') }}
        </a>

        <a href="{{ route('admin.dashboard',['status'=>'rejected']) }}"
           class="px-4 py-2 rounded-xl bg-red-100 text-red-700 whitespace-nowrap">
            {{ __('dashboard.filters.rejected') }}
        </a>

    </div>



    {{-- MOBILE CARD --}}
    <div class="space-y-4 md:hidden">

        @forelse($borrowings as $r)

        @php
            $statusColor = match($r->status){
                'requested' => 'bg-yellow-100 text-yellow-700',
                'approved'  => 'bg-blue-100 text-blue-700',
                'borrowed'  => 'bg-green-100 text-green-700',
                'rejected'  => 'bg-red-100 text-red-700',
                'returned'  => 'bg-gray-100 text-gray-700',
                default     => 'bg-gray-100 text-gray-700'
            };
        @endphp

        <div onclick="window.location='{{ route('admin.borrowings.show',$r->id) }}'"
             class="border rounded-2xl p-4 cursor-pointer hover:bg-indigo-50 transition">

            <div class="flex justify-between gap-3">
                <div>
                    <p class="font-semibold text-gray-800">{{ $r->user->first_name }}</p>
                    <p class="text-sm text-gray-500">{{ $r->book->title }}</p>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ \Carbon\Carbon::parse($r->request_date)->translatedFormat('d M Y') }}
                    </p>
                </div>

                <span class="px-3 py-1 h-fit rounded-full text-xs font-semibold {{ $statusColor }}">
                    {{ __('dashboard.status.'.$r->status) }}
                </span>
            </div>

        </div>

        @empty

        <div class="text-center py-8 text-gray-400">
            {{ __('dashboard.table.empty') }}
        </div>

        @endforelse

    </div>



    {{-- DESKTOP TABLE --}}
    <div class="hidden md:block rounded-2xl overflow-hidden border border-gray-100">

        <div class="overflow-x-auto">
            <table class="w-full text-sm table-auto">

                <thead class="bg-gray-50 border-b text-gray-400 text-xs uppercase">
                    <tr>
                        <th class="py-4 px-4 text-left">{{ __('dashboard.table.user') }}</th>
                        <th class="py-4 px-4 text-left">{{ __('dashboard.table.book') }}</th>
                        <th class="py-4 px-4 text-left">{{ __('dashboard.table.date') }}</th>
                        <th class="py-4 px-4 text-center">{{ __('dashboard.table.status') }}</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($borrowings as $r)

                @php
                    $statusColor = match($r->status){
                        'requested' => 'bg-yellow-100 text-yellow-700',
                        'approved'  => 'bg-blue-100 text-blue-700',
                        'borrowed'  => 'bg-green-100 text-green-700',
                        'rejected'  => 'bg-red-100 text-red-700',
                        'returned'  => 'bg-gray-100 text-gray-700',
                        default     => 'bg-gray-100 text-gray-700'
                    };
                @endphp

                <tr onclick="window.location='{{ route('admin.borrowings.show',$r->id) }}'"
                    class="border-b cursor-pointer hover:bg-indigo-50 transition">

                    <td class="py-4 px-4 font-medium text-gray-700">
                        {{ $r->user->first_name }}
                    </td>

                    <td class="py-4 px-4 text-gray-600">
                        {{ $r->book->title }}
                    </td>

                    <td class="py-4 px-4 text-gray-400">
                        {{ \Carbon\Carbon::parse($r->request_date)->translatedFormat('d M Y') }}
                    </td>

                    <td class="py-4 px-4 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                            {{ __('dashboard.status.'.$r->status) }}
                        </span>
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="4" class="text-center py-8 text-gray-400">
                        {{ __('dashboard.table.empty') }}
                    </td>
                </tr>

                @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>

</div>



{{-- ================= CHART JS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
const monthlyBorrow = @json($monthlyBorrow);
const dataValues = [];

for(let i = 1; i <= 12; i++){
    dataValues.push(monthlyBorrow[i] ?? 0);
}

new Chart(document.getElementById('borrowChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Borrow Requests',
            data: dataValues,
            tension: 0.4,
            fill: true,
            borderWidth: 3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales:{
            y:{
                beginAtZero:true,
                ticks:{ stepSize:1 }
            }
        }
    }
});
</script>

@endsection