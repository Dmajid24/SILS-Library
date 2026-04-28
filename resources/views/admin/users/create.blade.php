@extends('layouts.library')

@section('content')

<div class="max-w-4xl mx-auto space-y-8">

{{-- HEADER --}}
<div>
    <h1 class="text-3xl font-bold flex items-center gap-2">
        <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            {{ __('user_form.title') }}
        </span>
        👤
    </h1>

    <p class="text-gray-500 mt-1">
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
<div class="bg-white/80 backdrop-blur-xl border border-white/40 rounded-3xl shadow-xl p-8">

<form id="createUserForm" method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
@csrf

<div class="grid md:grid-cols-2 gap-6">

<div>
<label class="text-sm text-gray-600">{{ __('user_form.first_name') }}</label>
<input type="text" name="first_name" value="{{ old('first_name') }}"
class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white shadow-sm">
</div>

<div>
<label class="text-sm text-gray-600">{{ __('user_form.last_name') }}</label>
<input type="text" name="last_name" value="{{ old('last_name') }}"
class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white shadow-sm">
</div>

</div>

<div>
<label class="text-sm text-gray-600">{{ __('user_form.email') }}</label>
<input type="email" name="email" value="{{ old('email') }}"
class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white shadow-sm">
</div>

<div>
<label class="text-sm text-gray-600">{{ __('user_form.password') }}</label>
<input type="password" name="password"
class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white shadow-sm">
</div>

<div>
<label class="text-sm text-gray-600">{{ __('user_form.role') }}</label>

<select name="role" id="role"
class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white shadow-sm">

<option value="">
    {{ __('user_form.roles.select') }}
</option>

<option value="student">{{ __('user_form.roles.student') }}</option>
<option value="lecturer">{{ __('user_form.roles.lecturer') }}</option>
<option value="staff">{{ __('user_form.roles.staff') }}</option>
<option value="admin">{{ __('user_form.roles.admin') }}</option>

</select>
</div>

{{-- STUDENT --}}
<div id="studentFields" class="role-section hidden space-y-4 border-t pt-6">
<h3 class="font-semibold text-gray-700">{{ __('user_form.student_info') }}</h3>

<input type="text" name="nim" placeholder="NIM"
class="role-input w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">

<input type="text" name="major" placeholder="{{ __('user_form.major') }}"
class="role-input w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">

<input type="text" name="faculty" placeholder="{{ __('user_form.faculty') }}"
class="role-input w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">
</div>

{{-- LECTURER --}}
<div id="lecturerFields" class="role-section hidden space-y-4 border-t pt-6">
<h3 class="font-semibold text-gray-700">{{ __('user_form.lecturer_info') }}</h3>

<input type="text" name="nip" placeholder="NIP"
class="role-input w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">

<input type="text" name="degree" placeholder="{{ __('user_form.degree') }}"
class="role-input w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">

<input type="text" name="department" placeholder="{{ __('user_form.department') }}"
class="role-input w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">
</div>

{{-- STAFF --}}
<div id="staffFields" class="role-section hidden space-y-4 border-t pt-6">
<h3 class="font-semibold text-gray-700">{{ __('user_form.staff_info') }}</h3>

<input type="text" name="employee_id" placeholder="{{ __('user_form.employee_id') }}"
class="role-input w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">

<input type="text" name="job_position" placeholder="{{ __('user_form.job_position') }}"
class="role-input w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">

<input type="text" name="staff_department" placeholder="{{ __('user_form.department') }}"
class="role-input w-full px-4 py-3 rounded-xl border border-gray-300 bg-white">
</div>

{{-- BUTTON --}}
<div class="flex justify-end gap-3 pt-4">

<a href="{{ route('admin.users.index') }}"
class="px-5 py-2 rounded-lg border border-gray-300 text-gray-600">
    {{ __('user_form.cancel') }}
</a>

<button type="button"
onclick="validateBeforeModal()"
class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg">
    {{ __('user_form.create') }}
</button>

</div>

</form>
</div>

</div>

{{-- MODAL --}}
<div id="createUserModal"
class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[9999]">

<div class="bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full text-center">

<h2 class="text-lg font-semibold mb-3">
    {{ __('user_form.confirm_title') }}
</h2>

<p class="text-gray-500 text-sm mb-6">
    {{ __('user_form.confirm_message') }}
</p>

<div class="flex flex-col items-center gap-3">

<button onclick="submitForm()"
class="bg-indigo-600 text-white py-2 px-6 rounded-lg">
    {{ __('user_form.confirm_yes') }}
</button>

<button onclick="closeCreateUserModal()"
class="text-gray-500 text-sm hover:underline">
    {{ __('user_form.cancel') }}
</button>

</div>

</div>
</div>

@endsection