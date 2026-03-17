@extends('layouts.library')

@section('content')

<div class="max-w-4xl mx-auto py-10">

{{-- HEADER --}}
<div class="mb-6">
    <h1 class="text-3xl font-bold text-slate-800 flex items-center gap-2">
        ✏️ Edit Information
    </h1>
    <p class="text-gray-500 text-sm mt-1">
        Update announcement details below.
    </p>
</div>


{{-- VALIDATION ERROR --}}
@if ($errors->any())
<div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl">
    <ul class="list-disc pl-5 space-y-1">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


<div class="bg-white shadow-lg rounded-2xl p-8">

<form id="updateForm"
        method="POST"
        action="{{ route('information.update',$information->id) }}"
        enctype="multipart/form-data"
        class="space-y-6">
@csrf
@method('PUT')


{{-- TITLE --}}
<div>
<label class="block font-semibold text-gray-700 mb-1">
Title
</label>

<input type="text"
       name="title"
       value="{{ old('title',$information->title) }}"
       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
       placeholder="Example: Library Closed Tomorrow"
       required>
</div>


{{-- DESCRIPTION --}}
<div>
<label class="block font-semibold text-gray-700 mb-1">
Description
</label>

<textarea name="description"
          rows="5"
          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
          placeholder="Write announcement detail..."
          required>{{ old('description',$information->description) }}</textarea>
</div>


{{-- CURRENT IMAGE --}}
@if($information->image_content)
<div>
<p class="text-sm text-gray-500 mb-2">
Current Banner
</p>

<img src="{{ asset('storage/'.$information->image_content) }}"
     class="rounded-xl shadow w-full max-h-80 object-cover">
</div>
@endif


{{-- UPLOAD IMAGE --}}
<div>

<label class="block font-semibold text-gray-700 mb-1">
Replace Banner Image
</label>

<input type="file"
       name="image"
       id="imageUpload"
       class="mt-1 w-full">

<p class="text-xs text-gray-400 mt-1">
Optional • JPG, PNG • Max 2MB
</p>

{{-- preview --}}
<img id="previewImage"
     class="mt-4 rounded-xl hidden max-h-80 object-cover">

</div>


{{-- BUTTON --}}
<div class="flex justify-between pt-4">

<a href="{{ route('information.show',$information->id) }}"
   class="px-5 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 transition">
Cancel
</a>

<button type="button"
onclick="openUpdateModal()"
class="px-6 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-medium transition">
Update Information
</button>

</div>

</form>
{{-- CONFIRM UPDATE MODAL --}}
<div id="updateModal"
class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

<div class="bg-white rounded-2xl shadow-xl p-8 max-w-sm w-full text-center">

<h2 class="text-xl font-semibold mb-4">
Confirm Update
</h2>

<p class="text-gray-600 mb-6">
Are you sure you want to update this information?
</p>

<div class="flex justify-center gap-4">

<button onclick="submitUpdate()"
class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg">
Yes
</button>

<button onclick="closeUpdateModal()"
class="bg-gray-300 hover:bg-gray-400 px-5 py-2 rounded-lg">
No
</button>

</div>

</div>
</div>

</div>

</div>


{{-- IMAGE PREVIEW SCRIPT --}}
<script>

document.getElementById('imageUpload').addEventListener('change', function(e){

    const file = e.target.files[0];
    const preview = document.getElementById('previewImage');

    if(file){

        const reader = new FileReader();

        reader.onload = function(event){
            preview.src = event.target.result;
            preview.classList.remove('hidden');
        }

        reader.readAsDataURL(file);

    }

});

</script>

<script>

function openUpdateModal(){

    let form = document.getElementById("updateForm");

    if(form.checkValidity()){
        document.getElementById('updateModal').classList.remove('hidden');
        document.getElementById('updateModal').classList.add('flex');
    }else{
        form.reportValidity();
    }

}

function closeUpdateModal(){
    document.getElementById('updateModal').classList.add('hidden');
}

function submitUpdate(){
    document.getElementById("updateForm").submit();
}

</script>

@endsection