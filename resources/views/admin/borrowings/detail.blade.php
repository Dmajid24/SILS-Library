@extends('layouts.library')

@section('content')

<div class="max-w-6xl mx-auto space-y-8">

    {{-- HEADER --}}
    <div>
        <h1 class="text-3xl font-bold text-slate-800">{{ __('borrowed.detail_title') }}</h1>
        <p class="text-gray-500">{{ __('borrowed.detail_subtitle_admin') }}</p>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">

        {{-- ================= BOOK INFO ================= --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4 text-gray-700">📚 {{ __('borrowed.book_info') }}</h2>
            <div class="flex gap-6">
                <img src="{{ $borrowing->book->cover ? asset('storage/'.$borrowing->book->cover) : 'https://via.placeholder.com/60x80' }}"
                    class="w-28 h-40 object-cover rounded-lg shadow">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">{{ $borrowing->book->title }}</h3>
                    <p class="text-gray-600">{{ $borrowing->book->author }}</p>
                    <p class="text-gray-500 text-sm mt-2">{{ Str::limit($borrowing->book->description, 150) }}</p>
                </div>
            </div>
        </div>

        {{-- ================= USER INFO ================= --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4 text-gray-700">👤 {{ __('borrowed.borrower') }}</h2>
            <p class="font-semibold text-slate-800">{{ $borrowing->user->first_name }} {{ $borrowing->user->last_name }}</p>
            <p class="text-gray-500 text-sm">{{ $borrowing->user->email }}</p>
            <p class="mt-3 text-sm">
                <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700">
                    {{ ucfirst($borrowing->user->role) }}
                </span>
            </p>
        </div>
    </div>

    {{-- ================= TRANSACTION INFO ================= --}}
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-lg font-semibold mb-6 text-gray-700">📄 {{ __('borrowed.transaction') }}</h2>
        <div class="grid md:grid-cols-4 gap-6 text-sm">
            <div>
                <p class="text-gray-400">{{ __('borrowed.requested') }}</p>
                <p class="font-semibold">{{ $borrowing->created_at->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-gray-400">{{ __('borrowed.status_requested') }}</p>
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    @if($borrowing->status=='requested') bg-yellow-100 text-yellow-700
                    @elseif($borrowing->status=='approved') bg-blue-100 text-blue-700
                    @elseif($borrowing->status=='borrowed') bg-green-100 text-green-700
                    @elseif($borrowing->status=='returned') bg-gray-200 text-gray-700
                    @else bg-red-100 text-red-600
                    @endif">
                    {{ __('borrowing.status.'.$borrowing->status) }}
                </span>
            </div>
            <div>
                <p class="text-gray-400">{{ __('borrowed.due') }}</p>
                <p class="font-semibold">{{ $borrowing->due_date ? $borrowing->due_date->format('d M Y') : '-' }}</p>
            </div>
            <div>
                <p class="text-gray-400">{{ __('borrowed.returned') }}</p>
                <p class="font-semibold">{{ $borrowing->return_date ? $borrowing->return_date->format('d M Y') : '-' }}</p>
            </div>
        </div>

        {{-- ================= ACTION ================= --}}
        <div class="mt-8 flex gap-3">
            @if($borrowing->status == 'requested')
                <button onclick="openModal('approveModal')" class="px-5 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white transition">
                    {{ __('borrowed.admin_action.approve') }}
                </button>
                <button onclick="openModal('rejectModal')" class="px-5 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white transition">
                    {{ __('borrowed.admin_action.reject') }}
                </button>
            @elseif($borrowing->status == 'approved')
                <button onclick="openModal('borrowedModal')" class="px-5 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white">
                    {{ __('borrowed.admin_action.mark_borrowed') }}
                </button>
            @elseif($borrowing->status == 'borrowed')
                <button onclick="openModal('returnedModal')" class="px-5 py-2 rounded-lg bg-orange-600 hover:bg-orange-700 text-white">
                    {{ __('borrowed.admin_action.mark_returned') }}
                </button>
            @endif
        </div>
    </div>
</div>

{{-- ================= MODALS (Satu Struktur untuk semua) ================= --}}
@foreach(['approve', 'reject', 'borrowed', 'returned'] as $action)
<div id="{{ $action }}Modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-xl text-center w-full max-w-sm">
        <h2 class="font-semibold mb-3">{{ __('borrowed.admin_action.'.$action.'_title') }}</h2>
        <p class="text-sm text-gray-500 mb-5">{{ __('borrowed.admin_action.'.$action.'_confirm') }}</p>
        
        <form method="POST" action="{{ url('/'.$action.'/'.$borrowing->id) }}">
            @csrf
            <button class="w-full py-2 rounded-lg text-white font-semibold 
                {{ $action == 'reject' ? 'bg-red-500' : ($action == 'approve' ? 'bg-green-600' : ($action == 'borrowed' ? 'bg-indigo-600' : 'bg-orange-600')) }}">
                {{ __('borrowed.admin_action.yes_'.($action == 'reject' ? 'reject' : ($action == 'approve' ? 'approve' : 'confirm'))) }}
            </button>
        </form>
        <button onclick="closeModal('{{ $action }}Modal')" class="mt-3 text-gray-500 text-sm hover:underline">{{ __('borrowed.back') }}</button>
    </div>
</div>
@endforeach

<script>
    function openModal(id) {
        document.getElementById(id).classList.replace('hidden', 'flex');
    }
    function closeModal(id) {
        document.getElementById(id).classList.replace('flex', 'hidden');
    }
</script>

@endsection