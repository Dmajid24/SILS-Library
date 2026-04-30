@extends('layouts.library')

@section('content')

<div class="w-full px-4 sm:px-6 lg:px-0 space-y-6 sm:space-y-8">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>
            <h1 class="text-2xl sm:text-3xl font-bold flex items-center gap-2 flex-wrap">
                <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                    {{ __('import.import_preview') }}
                </span>
                <span>📄</span>
            </h1>

            <p class="text-sm sm:text-base text-gray-500 mt-1">
                {{ __('import.import_subtitle') }}
            </p>
        </div>

    </div>


    {{-- ================= SUMMARY ================= --}}
    @php
        $ready = collect($rows)->where('status','Ready')->count();
        $duplicate = collect($rows)->where('status','Duplicate')->count();
        $invalid = collect($rows)->where('status','Invalid Row')->count();
    @endphp

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">

        <div class="bg-white rounded-3xl shadow-sm border p-4 sm:p-6">
            <p class="text-xs sm:text-sm text-gray-500 font-medium">
                {{ __('import.total_rows') }}
            </p>
            <h3 class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2">
                {{ count($rows) }}
            </h3>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border p-4 sm:p-6">
            <p class="text-xs sm:text-sm text-gray-500 font-medium">
                {{ __('import.ready') }}
            </p>
            <h3 class="text-2xl sm:text-3xl font-bold text-green-600 mt-2">
                {{ $ready }}
            </h3>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border p-4 sm:p-6">
            <p class="text-xs sm:text-sm text-gray-500 font-medium">
                {{ __('import.duplicate') }}
            </p>
            <h3 class="text-2xl sm:text-3xl font-bold text-red-500 mt-2">
                {{ $duplicate }}
            </h3>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border p-4 sm:p-6">
            <p class="text-xs sm:text-sm text-gray-500 font-medium">
                {{ __('import.invalid') }}
            </p>
            <h3 class="text-2xl sm:text-3xl font-bold text-yellow-500 mt-2">
                {{ $invalid }}
            </h3>
        </div>

    </div>


    {{-- ================= MOBILE CARD VIEW ================= --}}
    <div class="lg:hidden space-y-4">

        @foreach($rows as $i => $row)
        <div class="bg-white rounded-3xl border shadow-sm p-5 space-y-3">

            <div class="flex justify-between items-start gap-3">
                <div>
                    <p class="text-xs text-gray-400">#{{ $i+1 }}</p>
                    <p class="font-semibold text-gray-800">
                        {{ $row['name'] }}
                    </p>
                </div>

                <div>
                    @if($row['status'] == 'Ready')
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                            {{ __('import.ready') }}
                        </span>
                    @elseif($row['status'] == 'Duplicate')
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                            {{ __('import.duplicate') }}
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">
                            {{ __('import.invalid') }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 text-sm">

                <div>
                    <p class="text-gray-400 text-xs">
                        @if($role == 'student')
                            {{ __('import.nim') }}
                        @elseif($role == 'lecturer')
                            {{ __('import.nip') }}
                        @else
                            {{ __('import.employee_id') }}
                        @endif
                    </p>

                    <p class="font-medium text-gray-700 break-words">
                        {{ $row['id_number'] }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs">
                        @if($role == 'student')
                            {{ __('import.major') }}
                        @elseif($role == 'lecturer')
                            {{ __('import.degree') }}
                        @else
                            {{ __('import.job_position') }}
                        @endif
                    </p>

                    <p class="font-medium text-gray-700 break-words">
                        {{ $row['field1'] }}
                    </p>
                </div>

                <div class="col-span-2">
                    <p class="text-gray-400 text-xs">
                        {{ __('import.department') }}
                    </p>

                    <p class="font-medium text-gray-700 break-words">
                        {{ $row['field2'] }}
                    </p>
                </div>

                <div class="col-span-2">
                    <p class="text-gray-400 text-xs">
                        {{ __('import.message') }}
                    </p>

                    <p class="text-xs text-gray-500 italic">
                        {{ __($row['message']) }}
                    </p>
                </div>

            </div>

        </div>
        @endforeach

    </div>


    {{-- ================= DESKTOP TABLE ================= --}}
    <div class="hidden lg:block bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full table-auto text-sm">

                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-left">No</th>

                        @if($role == 'student')
                            <th class="px-6 py-4 text-left">{{ __('import.nim') }}</th>
                            <th class="px-6 py-4 text-left">{{ __('import.name') }}</th>
                            <th class="px-6 py-4 text-left">{{ __('import.major') }}</th>
                            <th class="px-6 py-4 text-left">{{ __('import.faculty') }}</th>
                        @elseif($role == 'lecturer')
                            <th class="px-6 py-4 text-left">{{ __('import.nip') }}</th>
                            <th class="px-6 py-4 text-left">{{ __('import.name') }}</th>
                            <th class="px-6 py-4 text-left">{{ __('import.degree') }}</th>
                            <th class="px-6 py-4 text-left">{{ __('import.department') }}</th>
                        @elseif($role == 'staff')
                            <th class="px-6 py-4 text-left">{{ __('import.employee_id') }}</th>
                            <th class="px-6 py-4 text-left">{{ __('import.name') }}</th>
                            <th class="px-6 py-4 text-left">{{ __('import.job_position') }}</th>
                            <th class="px-6 py-4 text-left">{{ __('import.department') }}</th>
                        @endif

                        <th class="px-6 py-4 text-left">{{ __('import.status') }}</th>
                        <th class="px-6 py-4 text-left">{{ __('import.message') }}</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @foreach($rows as $i => $row)
                    <tr class="hover:bg-gray-50/50 transition">

                        <td class="px-6 py-4 text-gray-400">
                            {{ $i+1 }}
                        </td>

                        <td class="px-6 py-4 font-medium">
                            {{ $row['id_number'] }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $row['name'] }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $row['field1'] }}
                        </td>

                        <td class="px-6 py-4 text-gray-500">
                            {{ $row['field2'] }}
                        </td>

                        <td class="px-6 py-4">
                            @if($row['status'] == 'Ready')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                    {{ __('import.ready') }}
                                </span>
                            @elseif($row['status'] == 'Duplicate')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                    {{ __('import.duplicate') }}
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">
                                    {{ __('import.invalid') }}
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-xs text-gray-500 italic">
                            {{ __($row['message']) }}
                        </td>

                    </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>


    {{-- ================= FOOTER ACTION ================= --}}
    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3">

        <a href="{{ route('admin.users.index') }}"
           class="w-full sm:w-auto text-center px-6 py-3 border border-gray-300 text-gray-600 rounded-xl bg-white hover:bg-gray-100 transition font-medium">
            {{ __('announcements.btn_cancel') }}
        </a>

        @if($ready > 0)
        <form method="POST"
              action="{{ route('admin.users.import.confirm') }}"
              class="w-full sm:w-auto">
            @csrf

            <button class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow-lg hover:shadow-indigo-200 transition font-bold flex items-center justify-center gap-2">
                ✅ {{ __('import.confirm_import') }}
            </button>
        </form>
        @endif

    </div>

</div>

@endsection