@extends('layouts.library')

@section('content')
@if(session('success_count') !== null)

<div
    x-data="{ show:true }"
    x-show="show"
    x-transition
    x-init="setTimeout(() => show = false, 5000)"
    class="fixed top-6 right-6 z-50 w-[380px] bg-white shadow-2xl rounded-2xl border border-gray-100 overflow-hidden">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-5 py-4 text-white">
        <h3 class="font-semibold text-lg">
            Import Completed
        </h3>
    </div>

    {{-- BODY --}}
    <div class="p-5 space-y-3">

        <p class="text-green-600 font-medium">
            ✔ {{ session('success_count') }} users imported
        </p>

        <p class="text-red-500 font-medium">
            ⚠ {{ session('failed_count') }} skipped
        </p>

        @if(session('import_errors') && count(session('import_errors')) > 0)

        <div class="max-h-32 overflow-y-auto bg-red-50 rounded-xl p-3 text-sm text-red-600">
            @foreach(session('import_errors') as $error)
                <p>• {{ $error }}</p>
            @endforeach
        </div>

        @endif

        <button
            @click="show = false"
            class="w-full mt-2 bg-gray-100 hover:bg-gray-200 py-2 rounded-xl text-sm">
            Close
        </button>

    </div>

</div>

@endif
<div class="w-full space-y-8">

{{-- ================= HEADER ================= --}}
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

    <div>
        <h1 class="text-3xl font-bold flex items-center gap-2">
            <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                Manage Users
            </span>
            <span>👥</span>
        </h1>

        <p class="text-gray-500 mt-1">
            Manage and control system users
        </p>
    </div>

    <div class="flex items-center gap-3">

        {{-- SEARCH --}}
        <form method="GET" class="relative">
            <input
                name="search"
                value="{{ request('search') }}"
                placeholder="Search users..."
                class="pl-10 pr-4 py-2 rounded-xl border border-gray-200 bg-white shadow-sm
                       focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition"
            >
            <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
        </form>

        {{-- ADD --}}
        <a href="{{ route('admin.users.create') }}"
           class="px-5 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow-md hover:scale-105 transition flex items-center gap-2">
            <span>＋</span>
            Add User
        </a>
        <button onclick="openImportModal()"
            class="px-5 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow-md hover:scale-105 transition flex items-center gap-2">
            Import User
        </button>

    </div>

</div>


{{-- ================= TABLE CARD ================= --}}
<div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-white/40 overflow-hidden">

<div class="overflow-x-auto">

<table class="w-full text-sm">

<thead class="bg-white/60 text-gray-500 text-xs uppercase tracking-wider">
<tr>
<th class="p-5 text-left">User</th>
<th>Email</th>
<th>Role</th>
<th class="text-center">Action</th>
</tr>
</thead>

<tbody>

@forelse($users as $user)

<tr class="border-t hover:bg-white/60 transition">

{{-- USER --}}
<td class="p-5 flex items-center gap-4">

<div class="w-11 h-11 rounded-full flex items-center justify-center text-white font-semibold shadow
bg-gradient-to-r from-indigo-500 to-purple-500">
{{ strtoupper(substr($user->first_name,0,1)) }}
</div>

<div>
<p class="font-semibold text-gray-800">
{{ $user->first_name }} {{ $user->last_name }}
</p>

<p class="text-xs text-gray-400">
ID: {{ $user->id }}
</p>
</div>

</td>


{{-- EMAIL --}}
<td class="text-gray-600">
{{ $user->email }}
</td>


{{-- ROLE --}}
<td>
<span class="px-3 py-1 rounded-full text-xs font-semibold

@if($user->role == 'admin')
bg-purple-100 text-purple-700

@elseif($user->role == 'lecturer')
bg-blue-100 text-blue-700

@else
bg-green-100 text-green-700
@endif
">
{{ ucfirst($user->role) }}
</span>
</td>


{{-- ACTION --}}
<td>

<div class="flex justify-center gap-2">

<a href="{{ route('admin.users.edit',$user->id) }}"
class="px-3 py-2 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-indigo-50 transition">
✏️
</a>

<button type="button"
onclick="openDeleteModal('{{ route('admin.users.destroy',$user->id) }}')"
class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow-sm transition">
🗑
</button>

</div>

</td>

</tr>

@empty

<tr>
<td colspan="4" class="text-center py-14 text-gray-400">
No users found
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>


{{-- PAGINATION --}}
<div>
{{ $users->links() }}
</div>

</div>


{{-- ================= DELETE MODAL ================= --}}
<div id="deleteModal"
class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50">

<div class="bg-white rounded-2xl shadow-xl p-6 max-w-sm w-full text-center">

<h2 class="text-lg font-semibold text-gray-800 mb-3">
Delete User
</h2>

<p class="text-gray-500 text-sm mb-6">
Are you sure you want to delete this user?
</p>

<form id="deleteForm" method="POST">
@csrf
@method('DELETE')

<button type="submit"
class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg mb-2">
Yes, Delete
</button>
</form>

<button onclick="closeDeleteModal()"
class="text-gray-500 text-sm hover:underline">
Cancel
</button>

</div>
</div>

<div id="importModal"
class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

<div class="bg-white rounded-3xl p-8 w-full max-w-md shadow-2xl">

<h2 class="text-xl font-bold mb-5">Import Users</h2>
<div class="space-y-2 pt-2">

<a href="{{ route('admin.users.template','student') }}"
class="block w-full text-center bg-blue-50 text-blue-600 py-2 rounded-xl hover:bg-blue-100">
⬇ Download Student Template
</a>

<a href="{{ route('admin.users.template','lecturer') }}"
class="block w-full text-center bg-green-50 text-green-600 py-2 rounded-xl hover:bg-green-100">
⬇ Download Lecturer Template
</a>

<a href="{{ route('admin.users.template','staff') }}"
class="block w-full text-center bg-purple-50 text-purple-600 py-2 rounded-xl hover:bg-purple-100">
⬇ Download Staff Template
</a>

</div>
<form method="POST"
action="{{ route('admin.users.import.preview') }}"
enctype="multipart/form-data"
class="space-y-5">

@csrf

<div>
<label class="text-sm text-gray-600">Select Role</label>

<select name="role"
class="w-full mt-2 px-4 py-3 rounded-xl border border-gray-300">
<option value="student">Student</option>
<option value="lecturer">Lecturer</option>
<option value="staff">Staff</option>
</select>
</div>

<div>
<label class="text-sm text-gray-600">CSV File</label>

<input type="file"
name="file"
accept=".csv"
required
class="w-full mt-2 border rounded-xl px-4 py-3">

</div>

<div class="flex justify-end gap-3 pt-2">

<button type="button"
onclick="closeImportModal()"
class="px-4 py-2 border rounded-xl">
Cancel
</button>

<button type="submit"
class="px-5 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow-md hover:scale-105 transition flex items-center gap-2">
Preview CSV
</button>

</div>

</form>

</div>
</div>

{{-- ================= SCRIPT ================= --}}
<script>

function openDeleteModal(actionUrl){
    const modal = document.getElementById('deleteModal');
    const form  = document.getElementById('deleteForm');

    form.action = actionUrl;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteModal(){
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

</script>

<script>
function openImportModal(){
    document.getElementById('importModal').classList.remove('hidden');
    document.getElementById('importModal').classList.add('flex');
}

function closeImportModal(){
    document.getElementById('importModal').classList.add('hidden');
    document.getElementById('importModal').classList.remove('flex');
}
</script>
@endsection