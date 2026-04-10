@extends('layouts.library')

@section('content')

<div class="max-w-4xl mx-auto space-y-8">

{{-- HEADER --}}
<div>
    <h1 class="text-3xl font-bold flex items-center gap-2">
        <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            Add New User
        </span>
        👤
    </h1>

    <p class="text-gray-500 mt-1">
        Create new system user and assign role
    </p>
</div>

{{-- ERROR --}}
@if ($errors->any())
<div class="bg-red-100 text-red-700 px-4 py-3 rounded-xl text-sm">
    <ul class="space-y-1">
        @foreach ($errors->all() as $error)
            <li>• {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- CARD --}}
<div class="bg-white/80 backdrop-blur-xl border border-white/40 rounded-3xl shadow-xl p-8">

<form id="createUserForm" method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
@csrf

{{-- NAME --}}
<div class="grid md:grid-cols-2 gap-6">

<div>
<label class="text-sm text-gray-600">First Name</label>
<input type="text" name="first_name" value="{{ old('first_name') }}"
class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white shadow-sm">
</div>

<div>
<label class="text-sm text-gray-600">Last Name</label>
<input type="text" name="last_name" value="{{ old('last_name') }}"
class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white shadow-sm">
</div>

</div>

{{-- EMAIL --}}
<div>
<label class="text-sm text-gray-600">Email</label>
<input type="email" name="email" value="{{ old('email') }}"
class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white shadow-sm">
</div>

{{-- PASSWORD --}}
<div>
<label class="text-sm text-gray-600">Password</label>
<input type="password" name="password"
class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white shadow-sm">
</div>

{{-- ROLE --}}
<div>
<label class="text-sm text-gray-600">Role</label>

<select name="role" id="role"
class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white shadow-sm">
<option value="">-- Select Role --</option>
<option value="student" {{ old('role')=='student'?'selected':'' }}>Student</option>
<option value="lecturer" {{ old('role')=='lecturer'?'selected':'' }}>Lecturer</option>
<option value="staff" {{ old('role')=='staff'?'selected':'' }}>Staff</option>
<option value="admin" {{ old('role')=='admin'?'selected':'' }}>Admin</option>
</select>
</div>

{{-- STUDENT --}}
<div id="studentFields" class="role-section hidden space-y-4 border-t pt-6">
<h3 class="font-semibold text-gray-700">Student Info</h3>

<input type="text" name="nim" value="{{ old('nim') }}" placeholder="NIM"
class="role-input w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">

<input type="text" name="major" value="{{ old('major') }}" placeholder="Major"
class="role-input w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">

<input type="text" name="faculty" value="{{ old('faculty') }}" placeholder="Faculty"
class="role-input w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">
</div>

{{-- LECTURER --}}
<div id="lecturerFields" class="role-section hidden space-y-4 border-t pt-6">
<h3 class="font-semibold text-gray-700">Lecturer Info</h3>

<input type="text" name="nip" value="{{ old('nip') }}" placeholder="NIP"
class="role-input w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">

<input type="text" name="degree" value="{{ old('degree') }}" placeholder="Degree"
class="role-input w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">

<input type="text" name="department" value="{{ old('department') }}" placeholder="Department"
class="role-input w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">
</div>

{{-- STAFF --}}
<div id="staffFields" class="role-section hidden space-y-4 border-t pt-6">
<h3 class="font-semibold text-gray-700">Staff Info</h3>

<input type="text" name="employee_id" value="{{ old('employee_id') }}" placeholder="Employee ID"
class="role-input w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">

<input type="text" name="job_position" value="{{ old('job_position') }}" placeholder="Job Position"
class="role-input w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">

<input type="text" name="staff_department" value="{{ old('staff_department') }}" placeholder="Department"
class="role-input w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">
</div>

{{-- BUTTON --}}
<div class="flex justify-end gap-3 pt-4">

<a href="{{ route('admin.users.index') }}"
class="px-5 py-2 rounded-lg border border-gray-300 text-gray-600">
Cancel
</a>

<button type="button"
onclick="validateBeforeModal()"
class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg">
Create User
</button>

</div>

</form>
</div>
</div>

{{-- MODAL --}}
<div id="createUserModal"
class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[9999]">

<div class="bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full text-center">

<h2 class="text-lg font-semibold mb-3">Confirm Create</h2>

<p class="text-gray-500 text-sm mb-6">
Are you sure you want to create this user?
</p>

<div class="flex flex-col items-center gap-3">

<button onclick="submitForm()"
class="bg-indigo-600 text-white py-2 px-6 rounded-lg">
Yes, Create
</button>

<button onclick="closeCreateUserModal()"
class="text-gray-500 text-sm hover:underline">
Cancel
</button>

</div>

</div>
</div>

{{-- SCRIPT --}}
<script>

const roleSelect = document.getElementById('role');
const sections = document.querySelectorAll('.role-section');

function toggleFields(role){
    sections.forEach(section => {
        section.classList.add('hidden');
        section.querySelectorAll('.role-input').forEach(input => input.disabled = true);
    });

    const active = document.getElementById(role + 'Fields');

    if(active){
        active.classList.remove('hidden');
        active.querySelectorAll('.role-input').forEach(input => input.disabled = false);
    }
}

roleSelect.addEventListener('change', e => toggleFields(e.target.value));

document.addEventListener('DOMContentLoaded', () => {
    toggleFields("{{ old('role') }}");
});

function validateBeforeModal(){
    const form = document.getElementById('createUserForm');

    if(form.checkValidity()){
        openCreateUserModal();
    } else {
        form.reportValidity();
    }
}

function openCreateUserModal(){
    const modal = document.getElementById('createUserModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeCreateUserModal(){
    const modal = document.getElementById('createUserModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function submitForm(){
    document.getElementById('createUserForm').submit();
}

</script>

@endsection