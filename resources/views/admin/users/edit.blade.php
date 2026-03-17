@extends('layouts.library')

@section('content')

<div class="max-w-3xl mx-auto space-y-6">

{{-- HEADER --}}
<div>
<h1 class="text-3xl font-bold text-gray-800">
✏️ Edit User
</h1>

<p class="text-gray-500">
Update user information and permissions
</p>
</div>


{{-- VALIDATION ERROR --}}
@if($errors->any())
<div class="bg-red-100 text-red-700 p-4 rounded-lg">
<ul class="text-sm space-y-1">
@foreach($errors->all() as $error)
<li>• {{ $error }}</li>
@endforeach
</ul>
</div>
@endif


<div class="bg-white p-8 rounded-3xl shadow">

<form id="editForm"
action="{{ route('admin.users.update',$user->id) }}"
method="POST">

@csrf
@method('PUT')

<div class="space-y-6">

{{-- USER PREVIEW --}}
<div class="flex items-center gap-4 pb-4 border-b">

<div class="w-14 h-14 bg-indigo-500 text-white rounded-full flex items-center justify-center text-xl font-semibold">
{{ strtoupper(substr($user->first_name,0,1)) }}
</div>

<div>
<p class="font-semibold text-gray-800">
{{ $user->first_name }} {{ $user->last_name }}
</p>

<p class="text-sm text-gray-400">
User ID: {{ $user->id }}
</p>
</div>

</div>


{{-- FIRST NAME --}}
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
First Name
</label>

<input
name="first_name"
value="{{ old('first_name', $user->first_name) }}"
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none"
required>
</div>


{{-- LAST NAME --}}
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Last Name
</label>

<input
name="last_name"
value="{{ old('last_name', $user->last_name) }}"
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none"
required>
</div>


{{-- EMAIL --}}
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Email Address
</label>

<input
type="email"
name="email"
value="{{ old('email', $user->email) }}"
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none"
required>
</div>


{{-- ROLE --}}
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
User Role
</label>

<select
name="role"
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">

<option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>
👤 Student
</option>

<option value="lecturer" {{ $user->role == 'lecturer' ? 'selected' : '' }}>
🎓 Lecturer
</option>

<option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
👑 Admin
</option>

</select>

</div>

</div>


{{-- BUTTON --}}
<div class="mt-8 flex justify-end gap-3">

<a
href="{{ route('admin.users.index') }}"
class="border border-gray-300 px-5 py-2 rounded-lg hover:bg-gray-100 transition">
Cancel
</a>

<button
type="button"
onclick="openEditModal()"
class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition shadow">
Update User
</button>

</div>

</form>

</div>

</div>


{{-- ================= MODAL ================= --}}
<div id="editModal"
class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

<div class="bg-white rounded-2xl shadow-xl p-6 max-w-sm w-full text-center">

<h2 class="text-lg font-semibold mb-3 text-slate-800">
Confirm Update
</h2>

<p class="text-gray-600 mb-6 text-sm">
Are you sure you want to update this user?
</p>

<button
onclick="submitEditForm()"
class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg">
Yes, Update
</button>

<button
onclick="closeEditModal()"
class="mt-3 text-gray-500 text-sm">
Cancel
</button>

</div>

</div>


{{-- ================= SCRIPT ================= --}}
<script>

function openEditModal(){
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}

function closeEditModal(){
    document.getElementById('editModal').classList.add('hidden');
}

function submitEditForm(){
    document.getElementById('editForm').submit();
}

</script>

@endsection