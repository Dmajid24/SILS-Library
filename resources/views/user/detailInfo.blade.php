@extends('layouts.library')

@section('content')

    <div class="max-w-4xl mx-auto py-10">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

            {{-- IMAGE --}}
            @if($information->image_content)
                <img src="{{ asset('storage/'.$information->image_content) }}"
                class="w-full h-72 object-cover">
            @endif


            <div class="p-8">

                {{-- TITLE --}}
                <h1 class="text-3xl font-bold text-slate-800 mb-2">
                    {{ $information->title }}
                </h1>

                {{-- DATE --}}
                <p class="text-sm text-gray-500 mb-6">
                    Published on {{ $information->created_at->format('d M Y') }}
                </p>


                {{-- CONTENT --}}
                <div class="text-gray-700 leading-relaxed space-y-4">

                    <p>
                        {{ $information->description }}
                    </p>

                    @if($information->content)
                        <p>
                            {{ $information->content }}
                        </p>
                    @endif

                </div>


                {{-- ACTION BUTTONS --}}
                @if(auth()->id() == $information->creator_id || auth()->id() === 'admin') 

                    <div class="mt-10 pt-6 border-t flex gap-3">

                        <a href="{{ route('information.edit',$information->id) }}"
                        class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 text-gray-700 transition">
                        ✏️ Edit
                        </a>


                        <button
                        onclick="openDeleteModal()"
                        class="px-5 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white transition">
                            🗑 Delete
                        </button>

                    </div>

                @endif

            </div>
        </div>

    </div>


    {{-- ================= DELETE MODAL ================= --}}
    <div id="deleteModal"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

        <div class="bg-white rounded-2xl shadow-xl p-8 max-w-sm w-full text-center">

            <h2 class="text-xl font-semibold mb-4 text-slate-800">
                Delete Information
            </h2>

            <p class="text-gray-600 mb-6">
                Are you sure you want to delete this announcement?  
                This action cannot be undone.
            </p>

            <div class="flex justify-center gap-4">

                <form id="deleteForm"
                action="{{ route('information.destroy',$information->id) }}"
                method="POST">

                    @csrf
                    @method('DELETE')

                    <button
                    class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg">
                    Yes, Delete
                    </button>

                </form>

                <button
                onclick="closeDeleteModal()"
                class="bg-gray-300 hover:bg-gray-400 px-5 py-2 rounded-lg">
                    Cancel
                </button>

            </div>

        </div>

    </div>


    {{-- ================= SCRIPT ================= --}}
    <script>

        function openDeleteModal(){
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal(){
            document.getElementById('deleteModal').classList.add('hidden');
        }

    </script>

@endsection