@extends('layouts.library')

@section('content')

{{-- 1. ALERT NOTIFICATION --}}
@if(session('success_count') !== null)
<div x-data="{ show:true }"
     x-show="show"
     x-transition
     x-init="setTimeout(() => show = false, 5000)"
     class="fixed top-4 right-4 left-4 sm:left-auto sm:w-[380px] z-[60] bg-white shadow-2xl rounded-2xl border border-gray-100 overflow-hidden">

    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-5 py-4 text-white">
        <h3 class="font-semibold text-base sm:text-lg">
            {{ __('users.import_completed') }}
        </h3>
    </div>

    <div class="p-5 space-y-3">
        <p class="text-green-600 font-medium text-sm">
            ✔ {{ session('success_count') }} {{ __('users.users_imported') }}
        </p>

        <p class="text-red-500 font-medium text-sm">
            ⚠ {{ session('failed_count') }} {{ __('users.skipped') }}
        </p>

        @if(session('import_errors') && count(session('import_errors')) > 0)
        <div class="max-h-32 overflow-y-auto bg-red-50 rounded-xl p-3 text-sm text-red-600">
            @foreach(session('import_errors') as $error)
                <p>• {{ $error }}</p>
            @endforeach
        </div>
        @endif

        <button @click="show = false"
                class="w-full mt-2 bg-gray-100 hover:bg-gray-200 py-2 rounded-xl text-sm font-semibold transition">
            {{ __('users.close') }}
        </button>
    </div>
</div>
@endif

<div class="w-full space-y-8">

{{-- ================= HEADER ================= --}}
<div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

    <div>
        <h1 class="text-2xl sm:text-3xl font-bold flex items-center gap-2 flex-wrap">
            <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                {{ __('users.title') }}
            </span>
            <span>👥</span>
        </h1>

        <p class="text-gray-500 mt-1 text-sm sm:text-base">
            {{ __('users.subtitle') }}
        </p>
    </div>

    {{-- ACTIONS --}}
    <div class="flex flex-col sm:flex-row gap-3 w-full xl:w-auto">

        {{-- SEARCH --}}
        <form method="GET" class="relative w-full sm:w-72">
            <input
                name="search"
                value="{{ request('search') }}"
                placeholder="{{ __('users.search_placeholder') }}"
                class="pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-white shadow-sm focus:ring-2 focus:ring-indigo-400 outline-none transition w-full">

            <span class="absolute left-3 top-3 text-gray-400">🔍</span>
        </form>

        {{-- BUTTONS --}}
        <div class="grid grid-cols-2 sm:flex gap-3">

            <a href="{{ route('admin.users.create') }}"
               class="px-4 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow-md hover:shadow-indigo-200 text-center font-bold text-sm">
                ＋ <span class="hidden sm:inline">{{ __('users.add_user') }}</span>
            </a>

            <button onclick="openImportModal()"
                    class="px-4 py-3 bg-white border border-indigo-200 text-indigo-600 rounded-xl shadow-sm hover:bg-indigo-50 transition font-bold text-sm">
                📥 <span class="hidden sm:inline">{{ __('users.import_user') }}</span>
            </button>

        </div>

    </div>

</div>

{{-- ================= MOBILE CARD LIST ================= --}}
<div class="grid gap-4 lg:hidden">

@forelse($users as $user)

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 space-y-4">

    <div class="flex items-center gap-3">
        <div class="w-11 h-11 rounded-full flex items-center justify-center text-white font-bold bg-gradient-to-br from-indigo-500 to-purple-500">
            {{ strtoupper(substr($user->first_name,0,1)) }}
        </div>

        <div class="min-w-0">
            <p class="font-bold text-gray-800 truncate">
                {{ $user->first_name }} {{ $user->last_name }}
            </p>

            <p class="text-xs text-gray-400 truncate">
                {{ $user->email }}
            </p>
        </div>
    </div>

    <div class="flex items-center justify-between">
        <span class="text-xs text-gray-400">Role</span>

        <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase
            {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700' : ($user->role == 'lecturer' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
            {{ $user->role }}
        </span>
    </div>

    <div class="grid grid-cols-2 gap-2">

        <a href="{{ route('admin.users.edit',$user->id) }}"
           class="text-center py-2 rounded-xl bg-indigo-50 text-indigo-600 font-semibold text-sm">
            ✏️ Edit
        </a>

        <button type="button"
                onclick="openDeleteModal('{{ route('admin.users.destroy',$user->id) }}')"
                class="py-2 rounded-xl bg-red-50 text-red-600 font-semibold text-sm">
            🗑 Delete
        </button>

    </div>

</div>

@empty

<div class="bg-white rounded-2xl p-10 text-center text-gray-400 shadow">
    {{ __('users.empty') }}
</div>

@endforelse

</div>

{{-- ================= DESKTOP TABLE ================= --}}
<div class="hidden lg:block bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-white/40 overflow-hidden">

    <div class="overflow-x-auto">
        <table class="w-full text-sm">

            <thead class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="p-5 text-left">{{ __('users.table.user') }}</th>
                    <th class="p-5 text-left">{{ __('users.table.email') }}</th>
                    <th class="p-5 text-left">{{ __('users.table.role') }}</th>
                    <th class="p-5 text-center">{{ __('users.table.action') }}</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($users as $user)

                <tr class="hover:bg-white/60 transition">

                    <td class="p-5 flex items-center gap-4">
                        <div class="w-11 h-11 rounded-full flex items-center justify-center text-white font-bold bg-gradient-to-br from-indigo-500 to-purple-500">
                            {{ strtoupper(substr($user->first_name,0,1)) }}
                        </div>

                        <div>
                            <p class="font-bold text-gray-800">
                                {{ $user->first_name }} {{ $user->last_name }}
                            </p>

                            <p class="text-[10px] text-gray-400">
                                ID: {{ $user->id }}
                            </p>
                        </div>
                    </td>

                    <td class="p-5 text-gray-600">
                        {{ $user->email }}
                    </td>

                    <td class="p-5">
                        <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase
                            {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700' : ($user->role == 'lecturer' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                            {{ $user->role }}
                        </span>
                    </td>

                    <td class="p-5">
                        <div class="flex justify-center gap-2">

                            <a href="{{ route('admin.users.edit',$user->id) }}"
                               class="p-2 bg-white border border-gray-200 rounded-lg shadow-sm hover:text-indigo-600">
                                ✏️
                            </a>

                            <button type="button"
                                    onclick="openDeleteModal('{{ route('admin.users.destroy',$user->id) }}')"
                                    class="p-2 bg-white border border-red-100 text-red-500 rounded-lg shadow-sm hover:bg-red-50">
                                🗑
                            </button>

                        </div>
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="4" class="text-center py-20 text-gray-400">
                        {{ __('users.empty') }}
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>
    </div>

</div>

{{-- PAGINATION --}}
<div class="py-4">
    {{ $users->links() }}
</div>

</div>

{{-- ================= DELETE MODAL ================= --}}
<div id="deleteModal"
     class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-[70] p-4">

    <div class="bg-white rounded-2xl shadow-2xl p-6 sm:p-8 max-w-sm w-full text-center scale-95 transition-transform duration-300">

        <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
            ⚠️
        </div>

        <h2 class="text-xl font-bold text-gray-800 mb-2">
            {{ __('users.delete.title') }}
        </h2>

        <p class="text-gray-500 text-sm mb-8">
            {{ __('users.delete.question') }}
        </p>

        <form id="deleteForm" method="POST" class="space-y-3">
            @csrf
            @method('DELETE')

            <button type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl font-bold">
                {{ __('users.delete.submit') }}
            </button>
        </form>

        <button onclick="closeDeleteModal()"
                class="mt-4 text-gray-400 text-sm font-medium hover:text-gray-600">
            {{ __('users.delete.cancel') }}
        </button>

    </div>
</div>

{{-- ================= IMPORT MODAL ================= --}}
<div id="importModal"
     class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-[70] p-4">

    <div class="bg-white rounded-3xl p-6 sm:p-8 w-full max-w-md shadow-2xl scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                {{ __('users.import.title') }}
            </h2>

            <button onclick="closeImportModal()" class="text-gray-400 text-xl">✕</button>
        </div>

        <div class="space-y-2 mb-8">
            @foreach(['student','lecturer','staff'] as $role)
            <a href="{{ route('admin.users.template',$role) }}"
               class="block px-5 py-3 rounded-2xl text-sm font-bold bg-gray-50 hover:bg-gray-100">
                {{ ucfirst($role) }} Template
            </a>
            @endforeach
        </div>

        <form method="POST"
              action="{{ route('admin.users.import.process') }}"
              enctype="multipart/form-data"
              class="space-y-5">

            @csrf

            <select name="role"
                    class="w-full px-4 py-3 rounded-2xl border border-gray-200">
                <option value="student">Student</option>
                <option value="lecturer">Lecturer</option>
                <option value="staff">Staff</option>
            </select>

            <input type="file"
                   name="file"
                   accept=".csv"
                   required
                   class="w-full border-2 border-dashed border-gray-200 rounded-2xl px-4 py-5 text-sm">

            <div class="grid grid-cols-2 gap-3">

                <button type="button"
                        onclick="closeImportModal()"
                        class="py-3 border border-gray-200 rounded-2xl text-gray-500 font-bold">
                    {{ __('users.delete.cancel') }}
                </button>

                <button type="submit"
                        class="py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-2xl font-bold">
                    {{ __('users.import.preview') }}
                </button>

            </div>

        </form>

    </div>
</div>

<script>
function openDeleteModal(url){
    const modal = document.getElementById('deleteModal');
    document.getElementById('deleteForm').action = url;
    modal.classList.replace('hidden','flex');
}
function closeDeleteModal(){
    document.getElementById('deleteModal').classList.replace('flex','hidden');
}

function openImportModal(){
    document.getElementById('importModal').classList.replace('hidden','flex');
}
function closeImportModal(){
    document.getElementById('importModal').classList.replace('flex','hidden');
}

window.onclick = function(e){
    if(e.target.id === 'deleteModal') closeDeleteModal();
    if(e.target.id === 'importModal') closeImportModal();
}
</script>

@endsection