@extends('layouts.library')

@section('content')

<div class="max-w-4xl mx-auto space-y-8">

{{-- ================= HEADER ================= --}}
<div>
    <h1 class="text-3xl font-bold flex items-center gap-2">
        <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            Edit User
        </span>
        ✏️
    </h1>

    <p class="text-gray-500 mt-1">
        Update user information and permissions
    </p>
</div>


{{-- ================= ERROR ================= --}}
@if($errors->any())
<div class="bg-red-100 text-red-700 px-4 py-3 rounded-xl text-sm">
    <ul class="space-y-1">
        @foreach($errors->all() as $error)
            <li>• {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


{{-- ================= CARD ================= --}}
<div class="bg-white/80 backdrop-blur-xl border border-white/40 rounded-3xl shadow-xl p-8">

<form id="editUserForm"
action="{{ route('admin.users.update',$user->id) }}"
method="POST"
class="space-y-6">

@csrf
@method('PUT')

{{-- ================= USER PREVIEW ================= --}}
<div class="flex items-center gap-4 pb-6 border-b">

<div class="w-16 h-16 bg-gradient-to-r from-indigo-600 to-purple-600 
            text-white rounded-full flex items-center justify-center 
            text-xl font-semibold shadow">
{{ strtoupper(substr($user->first_name,0,1)) }}
</div>

<div>
<p class="font-semibold text-gray-800 text-lg">
{{ $user->first_name }} {{ $user->last_name }}
</p>

<p class="text-sm text-gray-400">
User ID: {{ $user->id }}
</p>
</div>

</div>


{{-- ================= NAME ================= --}}
<div class="grid md:grid-cols-2 gap-6">

<div>
<label class="text-sm font-medium text-gray-600 mb-1 block">
First Name
</label>

<input
name="first_name"
value="{{ old('first_name', $user->first_name) }}"
class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white shadow-sm
focus:ring-2 focus:ring-indigo-400 outline-none transition">
</div>


<div>
<label class="text-sm font-medium text-gray-600 mb-1 block">
Last Name
</label>

<input
name="last_name"
value="{{ old('last_name', $user->last_name) }}"
class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white shadow-sm
focus:ring-2 focus:ring-indigo-400 outline-none transition">
</div>

</div>


{{-- ================= EMAIL ================= --}}
<div>
<label class="text-sm font-medium text-gray-600 mb-1 block">
Email Address
</label>

<input
type="email"
name="email"
value="{{ old('email', $user->email) }}"
class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white shadow-sm
focus:ring-2 focus:ring-indigo-400 outline-none transition">
</div>


{{-- ================= ROLE ================= --}}
<div>
<label class="text-sm font-medium text-gray-600 mb-1 block">
User Role
</label>

<select
name="role"
id="role"
class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white shadow-sm
focus:ring-2 focus:ring-indigo-400 outline-none transition">

<option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>
👤 Student
</option>

<option value="lecturer" {{ $user->role == 'lecturer' ? 'selected' : '' }}>
🎓 Lecturer
</option>

<option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>
🧑‍💼 Staff
</option>

<option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
👑 Admin
</option>

</select>

</div>


{{-- ================= BUTTON ================= --}}
<div class="flex justify-end gap-3 pt-4">

<a
href="{{ route('admin.users.index') }}"
class="px-5 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition">
Cancel
</a>

<button
type="button"
onclick="openEditUserModal()"
class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg shadow hover:scale-105 transition">
Update User
</button>

</div>

</form>

</div>

</div>


{{-- ================= MODAL ================= --}}
<div id="editUserModal"
class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-[9999]">

<div class="bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full text-center animate-fadeIn">

<h2 class="text-lg font-semibold text-gray-800 mb-3">
Confirm Update
</h2>

<p class="text-gray-500 text-sm mb-6">
Are you sure you want to update this user?
</p>

<div class="flex flex-col items-center gap-3">

<button
onclick="submitEditForm()"
class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-2 px-6 rounded-lg hover:scale-105 transition">
Yes, Update
</button>

<button
onclick="closeEditUserModal()"
class="text-gray-500 text-sm hover:underline">
Cancel
</button>

</div>

</div>

</div>


{{-- ================= SCRIPT ================= --}}
<script>

function openEditUserModal(){
    const modal = document.getElementById('editUserModal');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.body.classList.add('overflow-hidden');
}

function closeEditUserModal(){
    const modal = document.getElementById('editUserModal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');

    document.body.classList.remove('overflow-hidden');
}

function submitEditForm(){
    document.getElementById('editUserForm').submit();
}

document.getElementById('editUserModal').addEventListener('click', function(e){
    if(e.target === this){
        closeEditUserModal();
    }
});

</script>


{{-- ================= ANIMATION ================= --}}
<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.2s ease-out;
}
</style>

@endsection