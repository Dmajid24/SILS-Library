@extends('layouts.library')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

{{-- HEADER --}}
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

    {{-- LEFT --}}
    <div>
        <h1 class="text-3xl font-bold text-slate-800">
            👥 Manage Users
        </h1>

        <p class="text-gray-500">
            Manage and control system users
        </p>
    </div>

    {{-- RIGHT ACTION AREA --}}
    <div class="flex items-center gap-3">

        {{-- SEARCH --}}
        <form method="GET">
            <input
                name="search"
                value="{{ request('search') }}"
                placeholder="Search users..."
                class="border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"
            >
        </form>

        {{-- ADD USER BUTTON --}}
        <a href="{{ route('admin.users.create') }}"
           class="bg-indigo-600 text-white px-5 py-2 rounded-lg shadow-sm
                  hover:bg-indigo-700 transition flex items-center gap-2">

            <span class="text-lg">＋</span>
            Add User
        </a>

    </div>

</div>


{{-- TABLE --}}
<div class="bg-white rounded-2xl shadow border overflow-hidden">

<div class="overflow-x-auto">

<table class="w-full text-sm">

<thead class="bg-gray-50 text-gray-600 text-xs uppercase">
<tr>
<th class="p-4 text-left">User</th>
<th>Email</th>
<th>Role</th>
<th class="text-center">Action</th>
</tr>
</thead>

<tbody>

@forelse($users as $user)

<tr class="border-b hover:bg-gray-50 transition">

{{-- USER --}}
<td class="p-4 flex items-center gap-3">

<div class="w-10 h-10 bg-indigo-700 text-white rounded-full flex items-center justify-center font-semibold">
{{ strtoupper(substr($user->first_name,0,1)) }}
</div>

<div>
<p class="font-semibold text-slate-800">
{{ $user->first_name }} {{ $user->last_name }}
</p>

<p class="text-xs text-gray-400">
ID: {{ $user->id }}
</p>
</div>

</td>


<td class="text-gray-600">
{{ $user->email }}
</td>


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

<a
href="{{ route('admin.users.edit',$user->id) }}"
class="px-3 py-2 bg-yellow-300 rounded-lg border border-gray-300 hover:bg-yellow-100 text-gray-700 transition">
✏️
</a>

<button
type="button"
onclick="openDeleteModal('{{ route('admin.users.destroy',$user->id) }}')"
class="px-3 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white">
🗑
</button>
</div>

</td>

</tr>

@empty

<tr>
<td colspan="4" class="text-center py-10 text-gray-400">
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
class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

<div class="bg-white rounded-2xl shadow-xl p-6 max-w-sm w-full text-center">

<h2 class="text-lg font-semibold mb-3 text-slate-800">
Delete User
</h2>

<p class="text-gray-600 mb-6 text-sm">
Are you sure you want to delete this user?  
This action cannot be undone.
</p>

<form id="deleteForm" method="POST">
    @csrf
    @method('DELETE')

    <button type="submit"
        class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg">
        Yes, Delete
    </button>
</form>

<button
onclick="closeDeleteModal()"
class="mt-3 text-gray-500 text-sm">
Cancel
</button>

</div>

</div>


{{-- ================= SCRIPT ================= --}}
<script>
function openDeleteModal(actionUrl){

    const modal = document.getElementById('deleteModal');
    const form  = document.getElementById('deleteForm');

    form.setAttribute('action', actionUrl);

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteModal(){
    document.getElementById('deleteModal')
        .classList.add('hidden');
}
</script>
@endsection