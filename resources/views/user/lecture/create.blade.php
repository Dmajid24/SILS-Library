@extends('layouts.library')

@section('content')

<div class="max-w-4xl mx-auto py-6 md:py-10 space-y-6 px-1">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-2 leading-tight">
            📢 {{ __('announcements.create_title') }}
        </h1>

        <p class="text-gray-500 text-sm md:text-base mt-1">
            {{ __('announcements.create_subtitle') }}
        </p>
    </div>



    {{-- VALIDATION ERROR --}}
    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-2xl">
        <ul class="list-disc pl-5 space-y-1 text-sm">
            @foreach ($errors->all() as $error)
                <li class="break-words">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif



    {{-- FORM CARD --}}
    <div class="bg-white shadow-xl rounded-3xl p-5 sm:p-6 md:p-8">

        <form id="createForm"
              method="POST"
              action="{{ route('information.store') }}"
              enctype="multipart/form-data"
              class="space-y-6">

            @csrf

            {{-- TITLE --}}
            <div>
                <label class="font-semibold text-gray-700 text-sm md:text-base">
                    {{ __('announcements.label_title') }}
                </label>

                <input type="text"
                       name="title"
                       value="{{ old('title') }}"
                       class="w-full mt-2 border rounded-2xl px-4 py-3 text-sm md:text-base focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                       required>
            </div>



            {{-- DESCRIPTION --}}
            <div>
                <label class="font-semibold text-gray-700 text-sm md:text-base">
                    {{ __('announcements.label_desc') }}
                </label>

                <textarea name="description"
                          rows="5"
                          class="w-full mt-2 border rounded-2xl px-4 py-3 text-sm md:text-base resize-none focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                          required>{{ old('description') }}</textarea>
            </div>



            {{-- UPLOAD IMAGE --}}
            <div>
                <label class="font-semibold text-gray-700 text-sm md:text-base">
                    {{ __('announcements.upload_banner') }}
                </label>

                <input type="file"
                       name="image"
                       id="imageUpload"
                       accept="image/*"
                       class="mt-2 w-full text-sm file:mr-4 file:px-4 file:py-2 file:rounded-xl file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">

                <p class="text-xs text-gray-400 mt-2 leading-relaxed">
                    {{ __('announcements.image_hint') }}
                </p>

                {{-- PREVIEW --}}
                <div id="previewWrapper" class="mt-4 hidden">
                    <img id="previewImage"
                         class="rounded-2xl shadow w-full max-h-80 object-cover">
                </div>
            </div>



            {{-- BUTTON --}}
            <div class="flex flex-col-reverse sm:flex-row sm:justify-between gap-3 pt-2 md:pt-4">

                <a href="{{ route('admin.information.index') }}"
                   class="w-full sm:w-auto text-center px-5 py-3 rounded-2xl bg-gray-200 hover:bg-gray-300 text-gray-700 transition font-medium">
                    {{ __('announcements.btn_cancel') }}
                </a>

                <button type="button"
                        onclick="createModal.open()"
                        class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white shadow transition font-semibold">
                    🚀 {{ __('announcements.create_btn') }}
                </button>

            </div>

        </form>

    </div>

</div>



{{-- ================= MODAL ================= --}}
<div id="createModal"
     class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-[999] px-4">

    <div id="createContent"
         class="bg-white rounded-3xl shadow-2xl p-6 md:p-8 max-w-sm w-full text-center
                transform scale-95 opacity-0 transition duration-300">

        <div class="text-4xl mb-3">📢</div>

        <h2 class="text-lg md:text-xl font-semibold mb-2 text-gray-800">
            {{ __('announcements.modal_create_title') }}
        </h2>

        <p class="text-gray-500 mb-6 text-sm md:text-base leading-relaxed">
            {{ __('announcements.modal_create_msg') }}
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-3">

            <button onclick="createModal.submit()"
                    class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-2xl shadow font-medium">
                {{ __('announcements.modal_yes_create') }}
            </button>

            <button onclick="createModal.close()"
                    class="w-full sm:w-auto bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-3 rounded-2xl font-medium">
                {{ __('announcements.modal_review') }}
            </button>

        </div>

    </div>

</div>



{{-- ================= SCRIPT ================= --}}
<script>
document.getElementById('imageUpload').addEventListener('change', function(e){
    const file = e.target.files[0];
    const preview = document.getElementById('previewImage');
    const wrapper = document.getElementById('previewWrapper');

    if(file){
        preview.src = URL.createObjectURL(file);
        wrapper.classList.remove('hidden');
    }
});

const createModal = {
    modal: document.getElementById('createModal'),
    content: document.getElementById('createContent'),

    open(){
        let form = document.getElementById("createForm");

        if(form.checkValidity()){
            this.modal.classList.remove('hidden');
            this.modal.classList.add('flex');

            setTimeout(()=>{
                this.content.classList.remove('scale-95','opacity-0');
                this.content.classList.add('scale-100','opacity-100');
            },10);

        }else{
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
        document.getElementById("createForm").submit();
    }
};

createModal.modal.addEventListener('click', function(e){
    if(e.target === this){
        createModal.close();
    }
});
</script>

@endsection