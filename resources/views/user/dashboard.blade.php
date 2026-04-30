@extends('layouts.library')

@section('content')

<div class="space-y-8 md:space-y-10">

{{-- ================= PHONE ALERT ================= --}}
@if(auth()->check() && auth()->user()->role !== 'admin' && empty(auth()->user()->phone))
<div id="phoneAlert"
     class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-amber-400 via-yellow-400 to-orange-400 p-[1px] shadow-lg">

    <div class="bg-white rounded-3xl px-4 sm:px-5 md:px-6 py-5">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            <div class="flex items-start gap-4">

                <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center text-2xl shrink-0">
                    📱
                </div>

                <div>
                    <h3 class="text-base md:text-lg font-bold text-gray-800">
                        {{ __('dashboard.alert_phone_title') }}
                    </h3>

                    <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                        {{ __('dashboard.alert_phone_msg') }}
                    </p>
                </div>

            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">

                <a href="{{ route('profile.edit') }}"
                   class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 transition text-center">
                    {{ __('dashboard.update_now') }}
                </a>

                <button onclick="document.getElementById('phoneAlert').remove()"
                        class="h-11 sm:w-11 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 transition">
                    ✕
                </button>

            </div>

        </div>

    </div>
</div>
@endif



{{-- ================= HERO ================= --}}
<div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 p-5 sm:p-6 md:p-10 shadow-xl text-white">

    <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>

    <div class="relative z-10 flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

        <div class="max-w-3xl">

            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold leading-tight">
                {{ __('dashboard.hero_greeting') }}
                {{ Auth::user()->first_name }}
                {{ Auth::user()->last_name }}
                {{ Auth::user()->role == 'lecturer' ? ', ' . Auth::user()->lectureProfile->degree : '' }}
            </h1>

            <p class="mt-2 text-white/80 text-sm md:text-base leading-relaxed">
                {{ __('dashboard.hero_subtitle') }}
            </p>

        </div>

        <form method="GET" class="w-full xl:w-96 shrink-0">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="{{ __('dashboard.search_placeholder') }}"
                class="w-full px-5 py-3 rounded-2xl text-gray-700 shadow focus:ring-2 focus:ring-white outline-none"
            >

        </form>

    </div>

</div>



{{-- ================= ANNOUNCEMENT ================= --}}
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
            📢 {{ __('dashboard.event_title') }}
        </h2>

        @if(auth()->user()->role === 'lecturer')
        <a href="{{ route('admin.information.index') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-xl shadow hover:bg-indigo-700 transition text-center">
            {{ __('dashboard.manage') }}
        </a>
        @endif

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        @forelse($info as $i)

        <a href="{{ route('information.show',$i->id) }}"
           class="group bg-white/80 backdrop-blur border border-white/40 p-5 md:p-6 rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition block">

            <h3 class="font-semibold text-base md:text-lg text-gray-800 line-clamp-2 group-hover:text-indigo-600 transition">
                {{ $i->title }}
            </h3>

            <p class="text-sm text-gray-500 mt-2 line-clamp-3 leading-relaxed">
                {{ Str::limit($i->description, 100) }}
            </p>

            <div class="mt-4 text-indigo-600 text-sm font-medium">
                {{ __('dashboard.read_more') }} →
            </div>

        </a>

        @empty

        <div class="col-span-full text-center py-12 bg-white rounded-3xl border border-dashed border-gray-200">

            <div class="text-5xl mb-3">📢</div>

            <p class="text-gray-400 text-lg font-medium">
                {{ __('dashboard.no_announcements') }}
            </p>

            <p class="text-sm text-gray-300 mt-1">
                {{ __('dashboard.Stay_tuned') }}
            </p>

        </div>

        @endforelse

    </div>

</div>



{{-- ================= BOOK SECTION ================= --}}
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
            📚 {{ __('dashboard.explore_title') }}
        </h2>

        <span class="text-sm text-gray-500">
            {{ count($book) }} {{ __('dashboard.books_available') }}
        </span>

    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-6">

        @forelse($book as $b)

        <div onclick="window.location='{{ route('books.show',$b->id) }}'"
             class="group bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition duration-300 cursor-pointer">

            {{-- COVER --}}
            <div class="relative overflow-hidden">

                <img
                    src="{{ $b->cover ? asset('storage/'.$b->cover) : 'https://placehold.co/400x500' }}"
                    class="w-full h-64 sm:h-72 object-cover group-hover:scale-110 transition duration-500">

                <div class="absolute top-3 right-3 bg-white/90 backdrop-blur px-3 py-1 rounded-xl text-xs font-semibold shadow">
                    {{ $b->stock }} {{ __('dashboard.stock_left') }}
                </div>

            </div>

            {{-- CONTENT --}}
            <div class="p-5">

                <h3 class="font-bold text-lg text-gray-800 line-clamp-2 group-hover:text-indigo-600 transition">
                    {{ $b->title }}
                </h3>

                <p class="text-sm text-gray-500 mt-1 line-clamp-1">
                    {{ $b->author }}
                </p>

                <div class="mt-3 flex items-center flex-wrap gap-2">

                    <span class="text-yellow-500 text-sm font-semibold">
                        ⭐ {{ number_format($b->reviews_avg_rating ?? 0,1) }}
                    </span>

                    <span class="text-xs text-gray-400">
                        ({{ $b->reviews_count ?? 0 }} reviews)
                    </span>

                </div>

                <div class="mt-5 flex justify-between items-center gap-3">

                    <span class="text-green-600 text-sm font-medium">
                        {{ __('dashboard.available') }}
                    </span>

                    <span class="text-indigo-600 text-sm font-semibold group-hover:translate-x-1 transition whitespace-nowrap">
                        {{ __('dashboard.detail') }} →
                    </span>

                </div>

            </div>

        </div>

        @empty

        <div class="col-span-full bg-white rounded-3xl border border-dashed border-gray-300 py-20 text-center">

            <div class="text-5xl mb-3">📚</div>

            <p class="text-gray-400 text-lg">
                {{ __('dashboard.no_books') }}
            </p>

        </div>

        @endforelse

    </div>

</div>



{{-- ================= FAQ ================= --}}
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
            ❓ {{ __('dashboard.faq_title') }}
        </h2>

        <a href="{{ route('faq') }}"
           class="px-4 py-2 rounded-xl bg-indigo-600 text-white shadow hover:bg-indigo-700 transition text-center">
            {{ __('dashboard.view_all') }} →
        </a>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        {{-- FAQ 1 --}}
        <div x-data="{ open:false }"
             class="bg-white/80 backdrop-blur border border-white/40 rounded-3xl p-5 md:p-6 shadow-sm hover:shadow-xl transition">

            <button @click="open=!open"
                    class="w-full flex justify-between items-start gap-4 text-left">

                <span class="font-semibold text-gray-800">
                    {{ __('dashboard.faq_q1') }}
                </span>

                <span class="text-indigo-600 text-xl shrink-0" x-text="open ? '−' : '+'"></span>

            </button>

            <div x-show="open" x-transition class="mt-4 text-sm text-gray-500 leading-relaxed">
                {{ __('dashboard.faq_a1') }}
            </div>

        </div>

        {{-- FAQ 2 --}}
        <div x-data="{ open:false }"
             class="bg-white/80 backdrop-blur border border-white/40 rounded-3xl p-5 md:p-6 shadow-sm hover:shadow-xl transition">

            <button @click="open=!open"
                    class="w-full flex justify-between items-start gap-4 text-left">

                <span class="font-semibold text-gray-800">
                    {{ __('dashboard.faq_q2') }}
                </span>

                <span class="text-indigo-600 text-xl shrink-0" x-text="open ? '−' : '+'"></span>

            </button>

            <div x-show="open" x-transition class="mt-4 text-sm text-gray-500 leading-relaxed">
                {{ __('dashboard.faq_a2') }}
            </div>

        </div>

        {{-- FAQ 3 --}}
        <div x-data="{ open:false }"
             class="bg-white/80 backdrop-blur border border-white/40 rounded-3xl p-5 md:p-6 shadow-sm hover:shadow-xl transition">

            <button @click="open=!open"
                    class="w-full flex justify-between items-start gap-4 text-left">

                <span class="font-semibold text-gray-800">
                    {{ __('dashboard.faq_q3') }}
                </span>

                <span class="text-indigo-600 text-xl shrink-0" x-text="open ? '−' : '+'"></span>

            </button>

            <div x-show="open" x-transition class="mt-4 text-sm text-gray-500 leading-relaxed">
                {{ __('dashboard.faq_a3') }}
            </div>

        </div>

    </div>

</div>

</div>

@endsection