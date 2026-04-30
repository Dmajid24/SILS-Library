@extends('layouts.library')

@section('content')

<div class="max-w-6xl mx-auto space-y-8">

    {{-- ================= BACK BUTTON ================= --}}
    @if (auth()->user()->role=='admin')
        <a href="{{ route('books.index') }}"
            class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-medium transition">
                ← {{ __('books.back_to_library') }}
        </a>  
    @else
        <a href="{{ route('user.dashboard') }}"
            class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-medium transition">
                ← {{ __('books.back_to_library') }}
        </a>
    @endif
   


    {{-- ================= BOOK HEADER ================= --}}
    <div class="bg-gradient-to-r from-slate-800 via-indigo-800 to-slate-700 rounded-3xl shadow-xl p-8">

        <div class="flex flex-col md:flex-row items-center gap-8">

            <img
                src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://placehold.co/120x160' }}"
                class="w-28 h-40 object-cover rounded-2xl shadow-lg">

            <div class="flex-1 text-white text-center md:text-left">

                <h1 class="text-3xl font-bold mb-2">
                    {{ $book->title }}
                </h1>

                <p class="text-gray-200 italic mb-5">
                    {{ __('books.by') }} {{ $book->author }}
                </p>

                <div class="flex flex-wrap justify-center md:justify-start gap-3 text-sm">

                    <span class="bg-white/20 px-4 py-2 rounded-full">
                        📚 {{ $book->publisher }}
                    </span>

                    <span class="bg-white/20 px-4 py-2 rounded-full">
                        📄 {{ $book->page }} {{ __('books.pages') }}
                    </span>

                    <span class="bg-white/20 px-4 py-2 rounded-full">
                        🏷 ISBN {{ $book->isbn }}
                    </span>

                    @if($book->stock > 0)
                        <span class="bg-green-500 px-4 py-2 rounded-full font-semibold">
                            ✔ {{ $book->stock }} {{ __('books.available') }}
                        </span>
                    @else
                        <span class="bg-red-500 px-4 py-2 rounded-full font-semibold">
                            {{ __('books.out_of_stock') }}
                        </span>
                    @endif

                </div>

            </div>

        </div>

    </div>



    {{-- ================= DESCRIPTION ================= --}}
    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8">

        <h2 class="text-xl font-bold text-gray-800 mb-4">
            {{ __('books.description_title') }}
        </h2>

        <p class="text-gray-600 leading-relaxed">
            {{ $book->description }}
        </p>

    </div>



    {{-- ================= BORROW SECTION ================= --}}
    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">

            <div>
                <h2 class="text-lg font-bold text-gray-800">
                    {{ __('books.borrow_title') }}
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    {{ __('books.borrow_subtitle') }}
                </p>
            </div>

            @if($book->stock > 0)

                <form id="borrowRequestForm"
                      action="{{ route('request.borrow',$book->id) }}"
                      method="POST">
                    @csrf

                    <button type="button"
                            onclick="borrowModal.open()"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl shadow-md font-semibold transition">
                        📚 {{ __('books.btn_request_borrow') }}
                    </button>
                </form>

            @else

                <button class="bg-gray-300 text-gray-600 px-8 py-3 rounded-xl cursor-not-allowed font-semibold">
                    {{ __('books.not_available') }}
                </button>

            @endif

        </div>

    </div>



    {{-- ================= REVIEW SECTION ================= --}}
    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8 space-y-6">

        <div class="flex justify-between items-center">

            <h2 class="text-xl font-bold text-gray-800">
                ⭐ {{ __('books.reviews_title') }}
            </h2>

            <a href="{{ route('review.index',$book->id) }}"
               class="text-indigo-600 text-sm font-semibold hover:underline">
                {{ __('books.view_all') }} →
            </a>

        </div>



        {{-- REVIEW FORM --}}
        <form method="POST"
              action="{{ route('review.store',$book->id) }}"
              class="space-y-5">

            @csrf


            {{-- STAR PICKER --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    {{ __('books.label_rating') }}
                </label>

                <input type="hidden" name="rating" id="ratingInput" required>

                <div class="flex items-center gap-2 flex-wrap" id="starPicker">

                    @for($i = 1; $i <= 5; $i++)
                        <button type="button"
                                data-value="{{ $i }}"
                                class="rating-star text-4xl text-gray-300 hover:scale-110 transition">
                            ★
                        </button>
                    @endfor

                    <span id="ratingText" class="ml-2 text-sm text-gray-500">
                        {{ __('books.placeholder_rating') }}
                    </span>

                </div>
            </div>



            {{-- COMMENT --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('books.label_comment') }}
                </label>

                <textarea
                    name="comment"
                    rows="3"
                    required
                    placeholder="{{ __('books.placeholder_comment') }}"
                    class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>



            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl shadow font-semibold transition">
                {{ __('books.btn_submit_review') }}
            </button>

        </form>

        <hr class="border-gray-100">



        {{-- PREVIEW REVIEW --}}
        <div class="space-y-4">

            @forelse($book->reviews->take(3) as $review)

                <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5">

                    <div class="flex justify-between items-center mb-2">

                        <span class="font-bold text-gray-800">
                            {{ $review->user->first_name  }} {{ $review->user->last_name  }}
                        </span>

                        <span class="text-yellow-500 text-sm">
                            {!! str_repeat('⭐', $review->rating) !!}
                        </span>

                    </div>

                    <p class="text-gray-600 italic text-sm">
                        "{{ $review->comment }}"
                    </p>

                </div>

            @empty

                <div class="text-center py-6 bg-gray-50 rounded-2xl border border-dashed border-gray-300 text-gray-400 text-sm">
                    {{ __('books.no_reviews') }}
                </div>

            @endforelse

        </div>

    </div>



    {{-- ================= PREMIUM ADMIN MANAGE REVIEW ================= --}}
    @if(auth()->check() && auth()->user()->role === 'admin')

    <div class="relative overflow-hidden bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white/50 p-8 space-y-8">

        <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-200/40 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-purple-200/40 rounded-full blur-3xl"></div>

        <div class="relative z-10 space-y-8">

            {{-- HEADER --}}
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
                        🛠 Manage Reviews
                    </h2>

                    <p class="text-gray-500 mt-1 text-sm">
                        Moderate user reviews and monitor feedback quality.
                    </p>
                </div>

                <div class="flex gap-3 flex-wrap">

                    <div class="bg-indigo-100 text-indigo-700 px-5 py-3 rounded-2xl text-sm font-semibold">
                        {{ $book->reviews->count() }} Reviews
                    </div>

                    <div class="bg-yellow-100 text-yellow-700 px-5 py-3 rounded-2xl text-sm font-semibold">
                        ⭐ {{ $book->reviews->count() ? number_format($book->reviews->avg('rating'),1) : '0.0' }}
                    </div>

                </div>

            </div>



            {{-- ANALYTICS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Average Rating</p>
                    <h3 class="text-4xl font-bold text-indigo-600 mt-2">
                        {{ $book->reviews->count() ? number_format($book->reviews->avg('rating'),1) : '0.0' }}
                    </h3>
                </div>

                <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Low Ratings</p>
                    <h3 class="text-4xl font-bold text-red-500 mt-2">
                        {{ $book->reviews->where('rating','<=',2)->count() }}
                    </h3>
                </div>

                <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
                    <p class="text-sm text-gray-500">5 Star Reviews</p>
                    <h3 class="text-4xl font-bold text-green-500 mt-2">
                        {{ $book->reviews->where('rating',5)->count() }}
                    </h3>
                </div>

            </div>



            {{-- REVIEW LIST --}}
            <div class="space-y-5">

                @forelse($book->reviews->sortByDesc('created_at') as $review)

                <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm hover:shadow-lg transition">

                    <div class="flex flex-col lg:flex-row lg:justify-between gap-5">

                        <div class="flex-1">

                            <div class="flex flex-wrap items-center gap-3 mb-3">

                                <div class="w-11 h-11 rounded-2xl bg-gradient-to-r from-indigo-500 to-purple-500 text-white flex items-center justify-center font-bold">
                                    {{ strtoupper(substr($review->user->first_name,0,1)) }}
                                </div>

                                <div>
                                    <h4 class="font-bold text-gray-800">
                                        {{ $review->user->first_name }}
                                    </h4>

                                    <p class="text-xs text-gray-400">
                                        {{ $review->created_at->diffForHumans() }}
                                    </p>
                                </div>

                                <span class="ml-auto bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    {!! str_repeat('⭐',$review->rating) !!}
                                </span>

                            </div>

                            <p class="text-gray-600 italic border-l-4 border-indigo-100 pl-4">
                                "{{ $review->comment }}"
                            </p>

                        </div>



                        <form action="{{ route('admin.review.delete',$review->id) }}"
                              method="POST"
                              onsubmit="return confirm('Delete this review?')">
                            @csrf
                            @method('DELETE')

                            <button class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-2xl text-sm font-semibold transition">
                                Delete
                            </button>
                        </form>

                    </div>

                </div>

                @empty

                <div class="bg-white rounded-3xl border border-dashed border-gray-300 p-10 text-center text-gray-400">
                    No reviews yet.
                </div>

                @endforelse

            </div>

        </div>

    </div>

    @endif

</div>



{{-- ================= BORROW MODAL ================= --}}
<div id="borrow-modal"
     class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50 px-4">

    <div id="modal-content"
         class="bg-white rounded-3xl shadow-2xl p-8 max-w-sm w-full text-center scale-95 opacity-0 transition duration-300">

        <div class="text-4xl mb-3">📚</div>

        <h2 class="text-xl font-bold text-gray-800 mb-2">
            {{ __('books.modal_confirm_title') }}
        </h2>

        <p class="text-gray-500 mb-6">
            {{ __('books.modal_confirm_msg') }}
        </p>

        <div class="space-y-2">

            <button onclick="borrowModal.submit()"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-bold transition">
                {{ __('books.modal_yes_borrow') }}
            </button>

            <button onclick="borrowModal.close()"
                    class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-xl font-medium transition">
                {{ __('announcements.btn_cancel') }}
            </button>

        </div>

    </div>

</div>



{{-- ================= SCRIPT ================= --}}
<script>
const borrowModal = {
    modal: document.getElementById('borrow-modal'),
    content: document.getElementById('modal-content'),

    open() {
        this.modal.classList.remove('hidden');
        this.modal.classList.add('flex');

        setTimeout(() => {
            this.content.classList.remove('scale-95', 'opacity-0');
            this.content.classList.add('scale-100', 'opacity-100');
        }, 10);
    },

    close() {
        this.content.classList.remove('scale-100', 'opacity-100');
        this.content.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            this.modal.classList.add('hidden');
            this.modal.classList.remove('flex');
        }, 200);
    },

    submit() {
        document.getElementById('borrowRequestForm').submit();
    }
};

borrowModal.modal.addEventListener('click', function(e){
    if(e.target === this){
        borrowModal.close();
    }
});

document.addEventListener('DOMContentLoaded', function () {

    const stars = document.querySelectorAll('.rating-star');
    const input = document.getElementById('ratingInput');
    const text = document.getElementById('ratingText');

    let currentRating = 0;

    function paintStars(rating){
        stars.forEach((star, index) => {
            if(index < rating){
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400');
            }else{
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });
    }

    stars.forEach((star, index) => {

        const value = index + 1;

        star.addEventListener('mouseenter', () => {
            paintStars(value);
        });

        star.addEventListener('click', () => {
            currentRating = value;
            input.value = value;

            const labels = {
                1: '⭐ Very Bad',
                2: '⭐⭐ Bad',
                3: '⭐⭐⭐ Good',
                4: '⭐⭐⭐⭐ Very Good',
                5: '⭐⭐⭐⭐⭐ Excellent'
            };

            text.textContent = labels[value];
            paintStars(value);
        });

    });

    document.getElementById('starPicker').addEventListener('mouseleave', () => {
        paintStars(currentRating);
    });

});
</script>

@endsection