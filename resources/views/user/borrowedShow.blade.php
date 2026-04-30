@extends('layouts.library')

@section('content')

<div class="max-w-5xl mx-auto space-y-6 sm:space-y-8">

    {{-- BACK --}}
    <a href="{{ route('borrowed.index') }}"
       class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-semibold transition group text-sm sm:text-base">
        <span class="group-hover:-translate-x-1 transition-transform mr-2">
            {{ __('borrowed.back') }}
        </span>
    </a>



    {{-- TITLE --}}
    <h1 class="text-2xl sm:text-3xl font-black text-gray-800 tracking-tight">
        📖 {{ __('borrowed.detail_title') }}
    </h1>



    {{-- MAIN CARD --}}
    <div class="bg-white/80 backdrop-blur-xl rounded-3xl sm:rounded-[2.5rem]
                shadow-2xl shadow-indigo-100/50 border border-white overflow-hidden">

        <div class="grid grid-cols-1 md:grid-cols-3">

            {{-- LEFT SIDE --}}
            <div class="p-6 sm:p-8 lg:p-10 bg-gray-50/50 border-b md:border-b-0 md:border-r border-gray-100 flex flex-col items-center justify-center text-center">

                <div class="relative group">

                    <img
                        src="{{ $borrow->book->cover ? asset('storage/'.$borrow->book->cover) : 'https://placehold.co/220x320' }}"
                        class="w-40 sm:w-48 lg:w-52 h-60 sm:h-68 lg:h-72 object-cover rounded-3xl shadow-2xl group-hover:scale-105 transition-transform duration-500">

                    {{-- STATUS --}}
                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 whitespace-nowrap shadow-xl">

                        @if($borrow->status == 'requested')
                        <span class="bg-amber-100 text-amber-700 px-4 sm:px-6 py-2 rounded-full text-[10px] sm:text-xs font-bold uppercase border border-amber-200">
                            🕐 {{ __('borrowed.status.requested') }}
                        </span>

                        @elseif($borrow->status == 'borrowed')
                        <span class="bg-blue-100 text-blue-700 px-4 sm:px-6 py-2 rounded-full text-[10px] sm:text-xs font-bold uppercase border border-blue-200">
                            📚 {{ __('borrowed.status.borrowed') }}
                        </span>

                        @elseif($borrow->status == 'returned')
                        <span class="bg-emerald-100 text-emerald-700 px-4 sm:px-6 py-2 rounded-full text-[10px] sm:text-xs font-bold uppercase border border-emerald-200">
                            ✔ {{ __('borrow.status.returned') }}
                        </span>
                        @endif

                    </div>

                </div>

            </div>



            {{-- RIGHT SIDE --}}
            <div class="md:col-span-2 p-6 sm:p-8 lg:p-10 space-y-6 sm:space-y-8">

                {{-- BOOK INFO --}}
                <div>

                    <h2 class="text-2xl sm:text-3xl font-black text-gray-900 leading-tight mb-2">
                        {{ $borrow->book->title }}
                    </h2>

                    <p class="text-indigo-600 font-semibold text-base sm:text-lg italic">
                        by {{ $borrow->book->author }}
                    </p>

                </div>



                {{-- INFO BOX --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-sm">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">
                            {{ __('borrowed.info.borrow_date') }}
                        </p>

                        <p class="font-bold text-gray-800 text-base sm:text-lg">
                            {{ $borrow->borrow_date ? \Carbon\Carbon::parse($borrow->borrow_date)->format('d M Y') : '-' }}
                        </p>
                    </div>



                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-sm">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">
                            {{ __('borrowed.info.return_date') }}
                        </p>

                        <p class="font-bold text-gray-800 text-base sm:text-lg">
                            {{ $borrow->return_date ? \Carbon\Carbon::parse($borrow->return_date)->format('d M Y') : '-' }}
                        </p>
                    </div>

                </div>



                {{-- TIMELINE --}}
                <div>

                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-5">
                        {{ __('borrowed.info.timeline') }}
                    </h3>

                    <div class="relative space-y-6 before:absolute before:left-[11px] before:top-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-indigo-200 before:via-gray-100 before:to-transparent">

                        {{-- STEP 1 --}}
                        <div class="relative flex items-start">
                            <div class="absolute left-0 top-1 w-6 h-6 rounded-full bg-amber-400 border-4 border-white shadow-sm z-10"></div>

                            <div class="ml-10">
                                <p class="text-sm font-bold text-gray-800">
                                    {{ __('borrowed.info.request_sent') }}
                                </p>

                                <p class="text-xs text-gray-400">
                                    {{ $borrow->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>



                        {{-- STEP 2 --}}
                        @if($borrow->status == 'borrowed' || $borrow->status == 'returned')
                        <div class="relative flex items-start">
                            <div class="absolute left-0 top-1 w-6 h-6 rounded-full bg-blue-500 border-4 border-white shadow-sm z-10"></div>

                            <div class="ml-10">
                                <p class="text-sm font-bold text-gray-800">
                                    {{ __('borrowed.info.book_taken') }}
                                </p>

                                <p class="text-xs text-gray-400">
                                    {{ $borrow->borrow_date ? \Carbon\Carbon::parse($borrow->borrow_date)->format('d M Y') : '-' }}
                                </p>
                            </div>
                        </div>
                        @endif



                        {{-- STEP 3 --}}
                        @if($borrow->status == 'returned')
                        <div class="relative flex items-start">
                            <div class="absolute left-0 top-1 w-6 h-6 rounded-full bg-emerald-500 border-4 border-white shadow-sm z-10"></div>

                            <div class="ml-10">
                                <p class="text-sm font-bold text-gray-800">
                                    {{ __('borrowed.info.book_returned') }}
                                </p>

                                <p class="text-xs text-gray-400">
                                    {{ $borrow->return_date ? \Carbon\Carbon::parse($borrow->return_date)->format('d M Y') : '-' }}
                                </p>
                            </div>
                        </div>
                        @endif

                    </div>

                </div>



                {{-- ACTION --}}
                @if($borrow->status == 'requested')
                <div class="pt-6 border-t border-gray-100">

                    <form id="cancelForm"
                          action="{{ route('borrow.cancel', $borrow->id) }}"
                          method="POST"
                          class="flex justify-end">

                        @csrf
                        @method('DELETE')

                        <button type="button"
                                onclick="cancelModal.open()"
                                class="w-full sm:w-auto flex justify-center items-center gap-2 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white px-6 sm:px-8 py-3 rounded-2xl font-bold transition shadow-lg shadow-red-100">
                            <span>✕</span>
                            {{ __('borrowed.action.cancel_btn') }}
                        </button>

                    </form>

                </div>
                @endif

            </div>

        </div>

    </div>

</div>



{{-- MODAL --}}
<div id="cancelModal"
     class="fixed inset-0 bg-gray-900/60 backdrop-blur-md hidden items-center justify-center z-[999] p-4">

    <div id="cancelContent"
         class="bg-white rounded-3xl shadow-2xl p-6 sm:p-10 max-w-sm w-full text-center scale-95 opacity-0 transition duration-300">

        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-5 text-2xl sm:text-3xl">
            ⚠️
        </div>

        <h2 class="text-xl sm:text-2xl font-black text-gray-800 mb-3">
            {{ __('borrowed.action.cancel_title') }}
        </h2>

        <p class="text-sm sm:text-base text-gray-500 mb-6 sm:mb-8 leading-relaxed">
            {{ __('borrowed.action.cancel_confirm') }}
        </p>

        <div class="space-y-3">

            <button onclick="cancelModal.submit()"
                    class="w-full bg-red-500 hover:bg-red-600 text-white py-3 sm:py-4 rounded-2xl font-bold shadow-xl shadow-red-200 transition">
                {{ __('borrowed.action.yes_cancel') }}
            </button>

            <button onclick="cancelModal.close()"
                    class="w-full bg-gray-100 hover:bg-gray-200 text-gray-600 py-3 sm:py-4 rounded-2xl font-bold transition">
                {{ __('borrowed.action.keep_request') }}
            </button>

        </div>

    </div>

</div>



<script>
const cancelModal = {
    modal: document.getElementById('cancelModal'),
    content: document.getElementById('cancelContent'),

    open(){
        this.modal.classList.remove('hidden');
        this.modal.classList.add('flex');

        setTimeout(() => {
            this.content.classList.remove('scale-95','opacity-0');
        }, 10);
    },

    close(){
        this.content.classList.add('scale-95','opacity-0');

        setTimeout(() => {
            this.modal.classList.add('hidden');
            this.modal.classList.remove('flex');
        }, 200);
    },

    submit(){
        document.getElementById('cancelForm').submit();
    }
};

window.onclick = (e) => {
    if(e.target === cancelModal.modal){
        cancelModal.close();
    }
}
</script>

@endsection