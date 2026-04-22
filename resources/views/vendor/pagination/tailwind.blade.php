@if ($paginator->hasPages())

<nav class="flex items-center justify-between mt-8">

    {{-- LEFT --}}
    <div class="text-sm text-gray-400">
        Showing {{ $paginator->firstItem() }}
        to {{ $paginator->lastItem() }}
        of {{ $paginator->total() }} results
    </div>

    {{-- RIGHT --}}
    <div class="flex items-center gap-2">

        {{-- PREV --}}
        @if ($paginator->onFirstPage())

            <span class="px-4 py-2 bg-white text-gray-300 rounded-xl border border-gray-200 cursor-not-allowed">
                ←
            </span>

        @else

            <a href="{{ $paginator->previousPageUrl() }}"
               class="px-4 py-2 bg-white rounded-xl border border-gray-200 hover:bg-indigo-50 transition shadow-sm">
                ←
            </a>

        @endif


        {{-- PAGE NUMBERS --}}
        @foreach ($elements as $element)

            @if (is_string($element))

                <span class="px-4 py-2 text-gray-400">
                    ...
                </span>

            @endif


            @if (is_array($element))

                @foreach ($element as $page => $url)

                    @if ($page == $paginator->currentPage())

                        <span class="px-4 py-2 rounded-xl text-white shadow-md
                        bg-gradient-to-r from-indigo-600 to-purple-600">
                            {{ $page }}
                        </span>

                    @else

                        <a href="{{ $url }}"
                           class="px-4 py-2 bg-white rounded-xl border border-gray-200
                           hover:bg-indigo-50 transition shadow-sm">
                            {{ $page }}
                        </a>

                    @endif

                @endforeach

            @endif

        @endforeach


        {{-- NEXT --}}
        @if ($paginator->hasMorePages())

            <a href="{{ $paginator->nextPageUrl() }}"
               class="px-4 py-2 bg-white rounded-xl border border-gray-200 hover:bg-indigo-50 transition shadow-sm">
                →
            </a>

        @else

            <span class="px-4 py-2 bg-white text-gray-300 rounded-xl border border-gray-200 cursor-not-allowed">
                →
            </span>

        @endif

    </div>

</nav>

@endif