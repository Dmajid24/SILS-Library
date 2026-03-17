@extends('layouts.library')

@section('content')

<div class="max-w-3xl mx-auto py-10">

<h1 class="text-3xl font-bold mb-6 text-indigo-700">
✨ Create Announcement
</h1>

<div class="bg-white shadow-xl rounded-2xl p-8">

<form action="{{ route('information.store') }}"
method="POST"
enctype="multipart/form-data"
class="space-y-6"
id="informForm">

@csrf

{{-- TITLE --}}
<div>
<label class="font-semibold">Title</label>
<input type="text"
name="title"
class="w-full mt-2 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400"
placeholder="Example: Library Closed Tomorrow"
required>
</div>

{{-- DESCRIPTION --}}
<div>
<label class="font-semibold">Description</label>
<textarea name="description"
rows="5"
class="w-full mt-2 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400"
placeholder="Write announcement detail..."
required></textarea>
</div>

{{-- IMAGE --}}
<div>
<label class="font-semibold">Banner Image (Optional)</label>
<input type="file"
name="image"
class="mt-2 w-full">
</div>

{{-- BUTTON --}}
<div class="flex justify-end gap-3">
@if (Auth()->user()->role==='lecture')
    <a href="{{ route('dashboard') }}"
    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">
    Cancel
    </a>
@else
    <a href="{{ route('admin.information.index') }}"
    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">
    Cancel
    </a>
@endif


<button type="button"
onclick="openPublishModal()"
class="px-6 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">
Publish 🚀
</button>

</div>

</form>

</div>

</div>


{{-- ================= CONFIRM MODAL ================= --}}
<div id="publishModal"
class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

<div class="bg-white rounded-2xl shadow-xl p-8 max-w-sm w-full text-center">

<h2 class="text-xl font-semibold mb-4">
Confirm Publish
</h2>

<p class="text-gray-600 mb-6">
Are you sure you want to publish this information?
</p>

<div class="flex justify-center gap-4">

<button onclick="submitInform()"
class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg">
Yes
</button>

<button onclick="closePublishModal()"
class="bg-gray-300 hover:bg-gray-400 px-5 py-2 rounded-lg">
No
</button>

</div>

</div>

</div>


<script>

function openPublishModal(){

    let form = document.getElementById('informForm');

    if(form.checkValidity()){
        document.getElementById('publishModal').classList.remove('hidden');
        document.getElementById('publishModal').classList.add('flex');
    }else{
        form.reportValidity();
    }

}

function closePublishModal(){
    document.getElementById('publishModal').classList.add('hidden');
}

function submitInform(){
    document.getElementById('informForm').submit();
}

</script>

@endsection