@extends('layouts.library')

@section('content')

<div class="max-w-3xl mx-auto py-10 space-y-6">

{{-- HEADER --}}
<div>
<h1 class="text-3xl font-bold text-gray-800">
✨ Create Announcement
</h1>
<p class="text-gray-500">
Share important updates with users
</p>
</div>


<div class="bg-white shadow-xl rounded-3xl p-8">

<form action="{{ route('information.store') }}"
method="POST"
enctype="multipart/form-data"
class="space-y-6"
id="informForm">

@csrf

{{-- TITLE --}}
<div>
<label class="font-semibold text-gray-700">Title</label>
<input type="text"
name="title"
class="w-full mt-2 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
placeholder="Example: Library Closed Tomorrow"
required>
</div>

{{-- DESCRIPTION --}}
<div>
<label class="font-semibold text-gray-700">Description</label>
<textarea name="description"
rows="5"
class="w-full mt-2 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
placeholder="Write announcement detail..."
required></textarea>
</div>

{{-- IMAGE --}}
<div>
<label class="font-semibold text-gray-700">Banner Image (Optional)</label>

<input type="file"
name="image"
accept="image/*"
onchange="previewImage(event)"
class="mt-2 w-full">

{{-- PREVIEW --}}
<div id="imagePreview" class="mt-4 hidden">
<img id="previewImg"
class="w-full h-48 object-cover rounded-xl shadow">
</div>

</div>


{{-- BUTTON --}}
<div class="flex justify-end gap-3 pt-4">

@if (Auth()->user()->role==='lecture')
<a href="{{ route('dashboard') }}"
class="px-5 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-700">
Cancel
</a>
@else
<a href="{{ route('admin.information.index') }}"
class="px-5 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-700">
Cancel
</a>
@endif

<button type="button"
onclick="publishModal.open()"
class="px-6 py-2 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 shadow transition">
🚀 Publish
</button>

</div>

</form>

</div>

</div>


{{-- ================= MODAL ================= --}}
<div id="publishModal"
class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-[999]">

<div id="publishContent"
class="bg-white rounded-3xl shadow-2xl p-8 max-w-sm w-full text-center
transform scale-95 opacity-0 transition duration-300">

<div class="text-4xl mb-3">🚀</div>

<h2 class="text-xl font-semibold mb-2 text-gray-800">
Publish Announcement
</h2>

<p class="text-gray-500 mb-6">
Are you sure you want to publish this information?
</p>

<div class="flex justify-center gap-3">

<button onclick="publishModal.submit()"
class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl shadow">
Yes, Publish
</button>

<button onclick="publishModal.close()"
class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-xl">
Review Again
</button>

</div>

</div>

</div>


<script>

const publishModal = {

modal: document.getElementById('publishModal'),
content: document.getElementById('publishContent'),

open(){

let form = document.getElementById('informForm');

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
document.getElementById('informForm').submit();
}

};


// klik luar modal
publishModal.modal.addEventListener('click', function(e){
if(e.target === this){
publishModal.close();
}
});


// IMAGE PREVIEW
function previewImage(event){
const input = event.target;
const preview = document.getElementById('imagePreview');
const img = document.getElementById('previewImg');

if(input.files && input.files[0]){
img.src = URL.createObjectURL(input.files[0]);
preview.classList.remove('hidden');
}
}

</script>

@endsection