@extends('layouts.library')

@section('content')

<div class="max-w-4xl mx-auto space-y-8">

{{-- ================= HEADER ================= --}}
<div>
    <h1 class="text-3xl font-bold text-slate-800">
        ➕ Add New User
    </h1>

    <p class="text-gray-500">
        Create new system user and assign role
    </p>
</div>


{{-- ================= GLOBAL ERROR ================= --}}
@if ($errors->any())
<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
    <ul class="list-disc ml-5 text-sm">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


{{-- ================= FORM ================= --}}
<div class="bg-white border rounded-2xl shadow-sm p-8">

<form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
@csrf


{{-- ================= NAME ================= --}}
<div class="grid md:grid-cols-2 gap-6">

<div>
<label class="block text-sm font-medium mb-1">First Name</label>
<input type="text" name="first_name"
value="{{ old('first_name') }}"
class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500
@error('first_name') border-red-500 @enderror">

@error('first_name')
<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
</div>


<div>
<label class="block text-sm font-medium mb-1">Last Name</label>
<input type="text" name="last_name"
value="{{ old('last_name') }}"
class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500">
</div>

</div>


{{-- ================= EMAIL + PHONE ================= --}}
<div >

<div>
<label class="block text-sm font-medium mb-1">Email</label>
<input type="email" name="email"
value="{{ old('email') }}"
class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500
@error('email') border-red-500 @enderror">

@error('email')
<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
</div>




</div>


{{-- ================= PASSWORD ================= --}}
<div>
<label class="block text-sm font-medium mb-1">Password</label>
<input type="password" name="password"
class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500
@error('password') border-red-500 @enderror">

@error('password')
<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
</div>


{{-- ================= ROLE ================= --}}
<div>
<label class="block text-sm font-medium mb-1">Role</label>

<select name="role" id="role"
class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500
@error('role') border-red-500 @enderror">

<option value="">-- Select Role --</option>
<option value="student" {{ old('role')=='student'?'selected':'' }}>Student</option>
<option value="lecturer" {{ old('role')=='lecturer'?'selected':'' }}>Lecturer</option>
<option value="staff" {{ old('role')=='staff'?'selected':'' }}>Staff</option>
<option value="admin" {{ old('role')=='admin'?'selected':'' }}>Admin</option>

</select>

@error('role')
<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
</div>


{{-- ================= STUDENT ================= --}}
<div id="studentFields" class="role-section hidden space-y-4 border-t pt-6">

<h3 class="font-semibold text-indigo-600">🎓 Student Information</h3>

<input type="text" name="nim" value="{{ old('nim') }}"
placeholder="NIM"
class="role-input w-full border rounded-lg px-4 py-2">

<input type="text" name="major" value="{{ old('major') }}"
placeholder="Major"
class="role-input w-full border rounded-lg px-4 py-2">

<input type="text" name="faculty" value="{{ old('faculty') }}"
placeholder="Faculty"
class="role-input w-full border rounded-lg px-4 py-2">

</div>


{{-- ================= LECTURER ================= --}}
<div id="lecturerFields" class="role-section hidden space-y-4 border-t pt-6">

<h3 class="font-semibold text-blue-600">👨‍🏫 Lecturer Information</h3>

<input type="text" name="nip" value="{{ old('nip') }}"
placeholder="NIP"
class="role-input w-full border rounded-lg px-4 py-2">

<input type="text" name="degree" value="{{ old('degree') }}"
placeholder="Degree"
class="role-input w-full border rounded-lg px-4 py-2">

<input type="text" name="department"
value="{{ old('lecturer_department') }}"
placeholder="Department"
class="role-input w-full border rounded-lg px-4 py-2">

</div>


{{-- ================= STAFF ================= --}}
<div id="staffFields" class="role-section hidden space-y-4 border-t pt-6">

<h3 class="font-semibold text-green-600">🧑‍💼 Staff Information</h3>

<input type="text" name="employee_id"
value="{{ old('employee_id') }}"
placeholder="Employee ID"
class="role-input w-full border rounded-lg px-4 py-2">

<input type="text" name="job_position"
value="{{ old('job_position') }}"
placeholder="Job Position"
class="role-input w-full border rounded-lg px-4 py-2">

<input type="text" name="staff_department"
value="{{ old('staff_department') }}"
placeholder="Department"
class="role-input w-full border rounded-lg px-4 py-2">

</div>


{{-- ================= BUTTON ================= --}}
<div class="flex justify-end gap-3 pt-4">

<a href="{{ route('admin.users.index') }}"
class="px-5 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">
Cancel
</a>

<button class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
Create User
</button>

</div>

</form>
</div>
</div>



{{-- ================= ROLE SCRIPT ================= --}}
<script>

const roleSelect = document.getElementById('role');
const sections = document.querySelectorAll('.role-section');

function toggleFields(role){

    sections.forEach(section => {
        section.classList.add('hidden');

        // disable input supaya tidak ikut submit
        section.querySelectorAll('.role-input')
            .forEach(input => input.disabled = true);
    });

    const active = document.getElementById(role + 'Fields');

    if(active){
        active.classList.remove('hidden');

        active.querySelectorAll('.role-input')
            .forEach(input => input.disabled = false);
    }
}

roleSelect.addEventListener('change', e => toggleFields(e.target.value));

document.addEventListener('DOMContentLoaded', () => {
    toggleFields("{{ old('role') }}");
});

</script>

@endsection