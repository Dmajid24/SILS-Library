@extends('layouts.library')

@section('content')

<div class="max-w-4xl mx-auto py-10 space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
            ✏️ {{ __('announcements.edit_title') }}
        </h1>
        <p class="text-gray-500 text-sm">
            {{ __('announcements.edit_subtitle') }}
        </p>
    </div>

    {{-- VALIDATION ERROR --}}
    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl">
        <ul class="list-disc pl-5 space-y-1 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white shadow-xl rounded-3xl p-8">

        <form id="updateForm"
              method="POST"
              action="{{ route('information.update',$information->id) }}"
              enctype="multipart/form-data"
              class="space-y-6">

            @csrf
            @method('PUT')

            {{-- TITLE --}}
            <div>
                <label class="font-semibold text-gray-700">{{ __('announcements.label_title') }}</label>
                <input type="text"
                       name="title"
                       value="{{ old('title',$information->title) }}"
                       class="w-full mt-2 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                       required>
            </div>

            {{-- DESCRIPTION --}}
            <div>
                <label class="font-semibold text-gray-700">{{ __('announcements.label_desc') }}</label>
                <textarea name="description"
                          rows="5"
                          class="w-full mt-2 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                          required>{{ old('description',$information->description) }}</textarea>
            </div>

            {{-- CURRENT IMAGE --}}
            @if($information->image_content)
            <div>
                <p class="text-sm text-gray-500 mb-2">{{ __('announcements.current_banner') }}</p>
                <img src="{{ asset('storage/'.$information->image_content) }}"
                     class="rounded-xl shadow w-full max-h-80 object-cover">
            </div>
            @endif

            {{-- UPLOAD IMAGE --}}
            <div>
                <label class="font-semibold text-gray-700">{{ __('announcements.replace_banner') }}</label>

                <input type="file"
                       name="image"
                       id="imageUpload"
                       accept="image/*"
                       class="mt-2 w-full">

                <p class="text-xs text-gray-400 mt-1">
                    {{ __('announcements.image_hint') }}
                </p>

                {{-- PREVIEW --}}
                <div id="previewWrapper" class="mt-4 hidden">
                    <img id="previewImage"
                         class="rounded-xl shadow w-full max-h-80 object-cover">
                </div>
            </div>

            {{-- BUTTON --}}
            <div class="flex justify-between pt-6">
                <a href="{{ route('information.show',$information->id) }}"
                   class="px-5 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-700 transition font-medium">
                    {{ __('announcements.btn_cancel') }}
                </a>

                <button type="button"
                        onclick="updateModal.open()"
                        class="px-6 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white shadow transition font-semibold">
                    💾 {{ __('announcements.update_btn') }}
                </button>
            </div>

        </form>
    </div>
</div>

{{-- ================= MODAL ================= --}}
<div id="updateModal"
     class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-[999]">

    <div id="updateContent"
         class="bg-white rounded-3xl shadow-2xl p-8 max-w-sm w-full text-center
                transform scale-95 opacity-0 transition duration-300">

        <div class="text-4xl mb-3">💾</div>

        <h2 class="text-xl font-semibold mb-2 text-gray-800">
            {{ __('announcements.modal_update_title') }}
        </h2>

        <p class="text-gray-500 mb-6">
            {{ __('announcements.modal_update_msg') }}
        </p>

        <div class="flex justify-center gap-3">
            <button onclick="updateModal.submit()"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl shadow font-medium">
                {{ __('announcements.modal_yes_update') }}
            </button>

            <button onclick="updateModal.close()"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-xl font-medium">
                {{ __('announcements.modal_review') }}
            </button>
        </div>
    </div>
</div>

{{-- ================= SCRIPT ================= --}}
<script>
    // IMAGE PREVIEW
    document.getElementById('imageUpload').addEventListener('change', function(e){
        const file = e.target.files[0];
        const preview = document.getElementById('previewImage');
        const wrapper = document.getElementById('previewWrapper');

        if(file){
            preview.src = URL.createObjectURL(file);
            wrapper.classList.remove('hidden');
        }
    });

    // MODAL CONTROLLER
    const updateModal = {
        modal: document.getElementById('updateModal'),
        content: document.getElementById('updateContent'),

        open(){
            let form = document.getElementById("updateForm");
            if(form.checkValidity()){
                this.modal.classList.remove('hidden');
                this.modal.classList.add('flex');
                setTimeout(()=>{
                    this.content.classList.remove('scale-95','opacity-0');
                    this.content.classList.add('scale-100','opacity-100');
                },10);
            } else {
                form.reportValidity();
            }
        },

        close(){
            this.content.classList.remove('scale-100','opacity-100');
            this.content.classList.add('scale-95','opacity-0');
            setTimeout(()=>{
                this.modal.classList.add('hidden');
                this.modal.classList.remove('flex');
            },200);
        },

        submit(){
            document.getElementById("updateForm").submit();
        }
    };

    // Close modal on outside click
    updateModal.modal.addEventListener('click', function(e){
        if(e.target === this){
            updateModal.close();
        }
    });
</script>

@endsection