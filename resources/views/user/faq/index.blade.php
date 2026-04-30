@extends('layouts.library')

@section('content')
<div class="max-w-7xl mx-auto space-y-10 px-4 md:px-6 py-6">

    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 p-8 md:p-10 text-white shadow-xl">
        <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-5xl font-bold">❓ Frequently Asked Questions</h1>
                <p class="mt-3 text-white/80 max-w-2xl">Find answers about borrowing books, returns, accounts, and using the library system.</p>
            </div>
            <a href="{{ url()->previous() }}" class="px-5 py-3 bg-white text-indigo-700 rounded-2xl font-semibold hover:scale-105 transition">
                ← Back
            </a>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">

        @php
        $faqs = [
            ['How do I borrow a book?','Open the book detail page and click Borrow Book if stock is available.'],
            ['How many books can I borrow?','You can borrow books based on system policy set by the admin.'],
            ['How long is the borrowing period?','Usually 7 to 14 days depending on library policy.'],
            ['How do I return a book?','Bring the physical book to the librarian or use return confirmation if enabled.'],
            ['What if I return late?','Late returns may receive fines or temporary borrowing restrictions.'],
            ['Can I extend my loan?','Yes, if no one else has reserved the book and admin allows extension.'],
            ['What if I lose a book?','Contact admin immediately. You may need replacement or compensation.'],
            ['How do I update my profile?','Go to Profile Settings and edit your personal information.'],
            ['Why can\'t I borrow books?','Possible reasons: incomplete phone number, overdue books, or account restriction.'],
            ['How do I contact admin?','Use the contact information on the website or visit the library desk.'],
        ];
        @endphp

        @foreach($faqs as $faq)
        <div x-data="{ open:false }" class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 hover:shadow-xl transition">
            <button @click="open=!open" class="w-full flex justify-between items-center gap-4 text-left">
                <span class="font-semibold text-gray-800 text-lg">{{ $faq[0] }}</span>
                <span class="text-indigo-600 text-2xl" x-text="open ? '−' : '+'"></span>
            </button>

            <div x-show="open" x-transition class="mt-4 text-sm text-gray-500 leading-relaxed">
                {{ $faq[1] }}
            </div>
        </div>
        @endforeach

    </div>

    <div class="rounded-3xl bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-100 p-8 text-center">
        <h3 class="text-2xl font-bold text-gray-800">Still Need Help?</h3>
        <p class="text-gray-500 mt-2">Please contact the librarian or administrator for further assistance.</p>
        <a href="{{ route('dashboard') }}" class="inline-block mt-5 px-6 py-3 rounded-2xl bg-indigo-600 text-white hover:bg-indigo-700 transition">
            Back to Dashboard
        </a>
    </div>

</div>
@endsection