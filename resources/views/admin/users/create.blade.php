@extends('layouts.library')

@section('content')

<div class="w-full max-w-4xl mx-auto space-y-6 sm:space-y-8">

{{-- HEADER --}}
<div>
    <h1 class="text-2xl sm:text-3xl font-bold flex items-center gap-2 flex-wrap">
        <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            {{ __('user_form.title') }}
        </span>
        <span>👤</span>
    </h1>

    <p class="text-gray-500 mt-1 text-sm sm:text-base">
        {{ __('user_form.subtitle') }}
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

{{-- FORM --}}
<div class="bg-white/80 backdrop-blur-xl border border-white/40 rounded-2xl sm:rounded-3xl shadow-xl p-5 sm:p-8">

<form id="createUserForm"
      method="POST"
      action="{{ route('admin.users.store') }}"
      class="space-y-5 sm:space-y-6">

@csrf

{{-- NAME --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

    <div>
        <label class="text-sm text-gray-600">
            {{ __('user_form.first_name') }}
        </label>

        <input type="text"
               name="first_name"
               value="{{ old('first_name') }}"
               class="w-full mt-2 px-4 py-3 rounded-xl border border-gray-300 bg-white shadow-sm focus:ring-2 focus:ring-indigo-400 outline-none">
    </div>

    <div>
        <label class="text-sm text-gray-600">
            {{ __('user_form.last_name') }}
        </label>

        <input type="text"
               name="last_name"
               value="{{ old('last_name') }}"
               class="w-full mt-2 px-4 py-3 rounded-xl border border-gray-300 bg-white shadow-sm focus:ring-2 focus:ring-indigo-400 outline-none">
    </div>

</div>

{{-- EMAIL --}}
<div>
    <label class="text-sm text-gray-600">
        {{ __('user_form.email') }}
    </label>

    <input type="email"
           name="email"
           value="{{ old('email') }}"
           class="w-full mt-2 px-4 py-3 rounded-xl border border-gray-300 bg-white shadow-sm focus:ring-2 focus:ring-indigo-400 outline-none">
</div>

{{-- PASSWORD --}}
<div>
    <label class="text-sm text-gray-600">
        {{ __('user_form.password') }}
    </label>

    <input type="password"
           name="password"
           class="w-full mt-2 px-4 py-3 rounded-xl border border-gray-300 bg-white shadow-sm focus:ring-2 focus:ring-indigo-400 outline-none">
</div>

{{-- ROLE --}}
<div>
    <label class="text-sm text-gray-600">
        {{ __('user_form.role') }}
    </label>

    <select name="role"
            id="role"
            onchange="toggleRoleFields()"
            class="w-full mt-2 px-4 py-3 rounded-xl border border-gray-300 bg-white shadow-sm focus:ring-2 focus:ring-indigo-400 outline-none">

        <option value="">
            {{ __('user_form.roles.select') }}
        </option>

        <option value="student"> {{ __('user_form.roles.student') }} </option>
        <option value="lecturer"> {{ __('user_form.roles.lecturer') }} </option>
        <option value="staff"> {{ __('user_form.roles.staff') }} </option>
        <option value="admin"> {{ __('user_form.roles.admin') }} </option>

    </select>
</div>

{{-- STUDENT --}}
<div id="studentFields"
     class="role-section hidden space-y-4 border-t pt-5">

    <h3 class="font-semibold text-gray-700 text-sm sm:text-base">
        {{ __('user_form.student_info') }}
    </h3>

    <input type="text"
           name="nim"
           placeholder="NIM"
           class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">

    <input type="text"
           name="major"
           placeholder="{{ __('user_form.major') }}"
           class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">

    <input type="text"
           name="faculty"
           placeholder="{{ __('user_form.faculty') }}"
           class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">
</div>

{{-- LECTURER --}}
<div id="lecturerFields"
     class="role-section hidden space-y-4 border-t pt-5">

    <h3 class="font-semibold text-gray-700 text-sm sm:text-base">
        {{ __('user_form.lecturer_info') }}
    </h3>

    <input type="text"
           name="nip"
           placeholder="NIP"
           class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">

    <input type="text"
           name="degree"
           placeholder="{{ __('user_form.degree') }}"
           class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">

    <input type="text"
           name="department"
           placeholder="{{ __('user_form.department') }}"
           class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">
</div>

{{-- STAFF --}}
<div id="staffFields"
     class="role-section hidden space-y-4 border-t pt-5">

    <h3 class="font-semibold text-gray-700 text-sm sm:text-base">
        {{ __('user_form.staff_info') }}
    </h3>

    <input type="text"
           name="employee_id"
           placeholder="{{ __('user_form.employee_id') }}"
           class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">

    <input type="text"
           name="job_position"
           placeholder="{{ __('user_form.job_position') }}"
           class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">

    <input type="text"
           name="staff_department"
           placeholder="{{ __('user_form.department') }}"
           class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">
</div>

{{-- BUTTON --}}
<div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-4">

    <a href="{{ route('admin.users.index') }}"
       class="px-5 py-3 rounded-xl border border-gray-300 text-gray-600 text-center hover:bg-gray-50 transition">
        {{ __('user_form.cancel') }}
    </a>

    <button type="button"
            onclick="validateBeforeModal()"
            class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow hover:scale-[1.02] transition">
        {{ __('user_form.create') }}
    </button>

</div>

</form>
</div>

</div>

{{-- MODAL --}}
<div id="createUserModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[9999] p-4">

<div class="bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full text-center">

    <h2 class="text-lg font-semibold mb-3">
        {{ __('user_form.confirm_title') }}
    </h2>

    <p class="text-gray-500 text-sm mb-6">
        {{ __('user_form.confirm_message') }}
    </p>

    <div class="flex flex-col gap-3">

        <button onclick="submitForm()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl">
            {{ __('user_form.confirm_yes') }}
        </button>

        <button onclick="closeCreateUserModal()"
                class="text-gray-500 text-sm hover:underline">
            {{ __('user_form.cancel') }}
        </button>

    </div>

</div>
</div>

<script>
function toggleRoleFields(){
    const role = document.getElementById('role').value;

    document.querySelectorAll('.role-section').forEach(el => {
        el.classList.add('hidden');
    });

    if(role === 'student'){
        document.getElementById('studentFields').classList.remove('hidden');
    }

    if(role === 'lecturer'){
        document.getElementById('lecturerFields').classList.remove('hidden');
    }

    if(role === 'staff'){
        document.getElementById('staffFields').classList.remove('hidden');
    }
}

function validateBeforeModal(){
    const form = document.getElementById('createUserForm');

    if(form.checkValidity()){
        openCreateUserModal();
    }else{
        form.reportValidity();
    }
}

function openCreateUserModal(){
    document.getElementById('createUserModal').classList.remove('hidden');
    document.getElementById('createUserModal').classList.add('flex');
}

function closeCreateUserModal(){
    document.getElementById('createUserModal').classList.add('hidden');
    document.getElementById('createUserModal').classList.remove('flex');
}

function submitForm(){
    document.getElementById('createUserForm').submit();
}

window.onclick = function(e){
    const modal = document.getElementById('createUserModal');
    if(e.target === modal){
        closeCreateUserModal();
    }
}
</script>

@endsection