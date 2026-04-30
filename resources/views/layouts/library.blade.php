{{-- resources/views/layouts/library.blade.php --}}

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title>{{ $school->name ?? __('layout.library_system') }}</title>

@vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="min-h-screen flex flex-col bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 text-gray-800 overflow-x-hidden">

{{-- ================= HEADER ================= --}}
<header class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-white/40 shadow-sm">

<div class="w-full max-w-screen-2xl mx-auto px-3 sm:px-6 lg:px-10">

<div class="flex items-center justify-between py-4 gap-3">

{{-- LOGO --}}
@if(Auth::user()->role == 'admin')
<a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 min-w-0 flex-1">
@else
<a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 min-w-0 flex-1">
@endif

@if($school && $school->logo)
<img src="{{ asset('storage/'.$school->logo) }}"
class="w-10 h-10 rounded-xl object-contain shadow shrink-0">
@endif

<div class="min-w-0">
<h1 class="font-bold truncate text-sm sm:text-base bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
{{ $school->name ?? __('layout.library_system') }}
</h1>

<p class="text-xs text-gray-500 truncate">
{{ __('layout.smart_library') }}
</p>
</div>

</a>

{{-- MOBILE BUTTON --}}
<button onclick="toggleMobileMenu()"
class="lg:hidden w-11 h-11 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-xl shrink-0">
☰
</button>

{{-- DESKTOP NAV --}}
<nav class="hidden lg:flex items-center gap-4 text-sm font-medium shrink-0">

<a href="{{ route('dashboard') }}"
class="text-gray-600 hover:text-indigo-600 transition">
{{ __('layout.dashboard') }}
</a>

@if(Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin')
<a href="{{ route('borrowed.index') }}"
class="text-gray-600 hover:text-purple-600 transition">
{{ __('layout.my_borrowed') }}
</a>
@endif

<a href="{{ route('faq') }}"
class="text-gray-600 hover:text-pink-600 transition">
FAQ
</a>

<div class="flex items-center bg-gray-100 rounded-xl p-1 shadow-sm">

<a href="{{ route('lang.switch',['locale'=>'id']) }}"
class="px-3 py-1 rounded-lg text-xs font-semibold transition {{ app()->getLocale() == 'id' ? 'bg-indigo-600 text-white shadow' : 'text-gray-600 hover:bg-white' }}">
ID
</a>

<a href="{{ route('lang.switch',['locale'=>'en']) }}"
class="px-3 py-1 rounded-lg text-xs font-semibold transition {{ app()->getLocale() == 'en' ? 'bg-indigo-600 text-white shadow' : 'text-gray-600 hover:bg-white' }}">
EN
</a>

</div>

<div class="relative">

<button onclick="toggleMenu()" class="flex items-center gap-2">

<div class="w-10 h-10 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold flex items-center justify-center shadow">
{{ strtoupper(substr(Auth::user()->first_name ?? Auth::user()->name,0,1)) }}
</div>

</button>

<div id="profileMenu"
class="hidden absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">

<a href="{{ route('profile.edit') }}"
class="block px-4 py-3 text-sm hover:bg-indigo-50">
{{ __('layout.profile') }}
</a>

<button onclick="openLogoutModal()"
class="w-full text-left px-4 py-3 text-sm hover:bg-red-50">
{{ __('layout.logout') }}
</button>

</div>

</div>

</nav>

</div>

{{-- MOBILE MENU --}}
<div id="mobileMenu" class="hidden lg:hidden pb-4">

<div class="bg-white rounded-2xl border border-gray-100 shadow p-4 space-y-3">

<a href="{{ route('dashboard') }}" class="block py-2 text-gray-700">
{{ __('layout.dashboard') }}
</a>

@if(Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin')
<a href="{{ route('borrowed.index') }}" class="block py-2 text-gray-700">
{{ __('layout.my_borrowed') }}
</a>
@endif

<a href="{{ route('faq') }}" class="block py-2 text-gray-700">
FAQ
</a>

<a href="{{ route('profile.edit') }}" class="block py-2 text-gray-700">
{{ __('layout.profile') }}
</a>

<div class="flex gap-2 pt-2">

<a href="{{ route('lang.switch',['locale'=>'id']) }}"
class="flex-1 text-center px-4 py-2 rounded-xl text-sm font-semibold {{ app()->getLocale() == 'id' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }}">
ID
</a>

<a href="{{ route('lang.switch',['locale'=>'en']) }}"
class="flex-1 text-center px-4 py-2 rounded-xl text-sm font-semibold {{ app()->getLocale() == 'en' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }}">
EN
</a>

</div>

<button onclick="openLogoutModal()"
class="w-full mt-2 px-4 py-3 rounded-xl bg-red-500 text-white">
{{ __('layout.logout') }}
</button>

</div>

</div>

</div>
</header>

{{-- ================= MAIN ================= --}}
<main class="flex-1 w-full min-w-0 overflow-x-hidden">

<div class="w-full max-w-screen-2xl mx-auto px-3 sm:px-6 lg:px-10 py-5 md:py-8">

@if(session('success'))
<div id="successBanner"
class="fixed top-4 right-3 left-3 md:left-auto md:w-auto z-[9999] bg-green-500 text-white px-6 py-4 rounded-2xl shadow-lg opacity-0 -translate-y-5 transition-all duration-500">
{{ session('success') }}
</div>
@endif

@if(session('error'))
<div id="errorBanner"
class="fixed top-4 right-3 left-3 md:left-auto md:w-auto z-[9999] bg-red-500 text-white px-6 py-4 rounded-2xl shadow-lg opacity-0 -translate-y-5 transition-all duration-500">
{{ session('error') }}
</div>
@endif

@if ($errors->any())
<div id="validationBanner"
class="fixed top-4 right-3 left-3 md:left-auto md:w-auto z-[9999] bg-red-500 text-white px-6 py-4 rounded-2xl shadow-lg opacity-0 -translate-y-5 transition-all duration-500">

<ul class="text-sm space-y-1">
@foreach($errors->all() as $error)
<li>• {{ $error }}</li>
@endforeach
</ul>

</div>
@endif

<div class="w-full min-w-0 overflow-x-hidden">
@yield('content')
</div>

</div>

</main>

{{-- ================= FOOTER ================= --}}
<footer class="bg-white/80 backdrop-blur border-t border-white/40">

<div class="w-full max-w-screen-2xl mx-auto px-3 sm:px-6 lg:px-10 py-6 flex flex-col md:flex-row items-center justify-between gap-3 text-sm text-gray-500">

<div class="flex items-center gap-2 min-w-0">

@if($school && $school->logo)
<img src="{{ asset('storage/'.$school->logo) }}"
class="w-6 h-6 object-contain shrink-0">
@endif

<span class="truncate">{{ $school->name ?? __('layout.school') }}</span>

</div>

<div>
© {{ date('Y') }} {{ __('layout.library_system') }}
</div>

</div>

</footer>

<form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
@csrf
</form>

<div id="logoutModal"
class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-[9999] p-4">

<div class="bg-white rounded-3xl shadow-xl w-full max-w-sm p-6">

<h2 class="text-lg font-bold text-gray-800">
{{ __('layout.confirm_logout') }}
</h2>

<p class="text-sm text-gray-500 mt-2">
{{ __('layout.logout_question') }}
</p>

<div class="mt-6 flex flex-col sm:flex-row justify-end gap-3">

<button onclick="closeLogoutModal()"
class="px-4 py-2 rounded-xl border hover:bg-gray-100">
{{ __('layout.cancel') }}
</button>

<button onclick="submitLogout()"
class="px-4 py-2 rounded-xl bg-red-500 text-white hover:bg-red-600">
{{ __('layout.yes_logout') }}
</button>

</div>

</div>

</div>

<script>
function toggleMenu(){
document.getElementById('profileMenu').classList.toggle('hidden');
}

function toggleMobileMenu(){
document.getElementById('mobileMenu').classList.toggle('hidden');
}

function openLogoutModal(){
document.getElementById('logoutModal').classList.remove('hidden');
document.getElementById('logoutModal').classList.add('flex');
}

function closeLogoutModal(){
document.getElementById('logoutModal').classList.add('hidden');
document.getElementById('logoutModal').classList.remove('flex');
}

function submitLogout(){
document.getElementById('logoutForm').submit();
}

window.addEventListener('DOMContentLoaded', () => {
['successBanner','errorBanner','validationBanner'].forEach(id => {
const el = document.getElementById(id);

if(el){
setTimeout(() => {
el.classList.remove('opacity-0','-translate-y-5');
},100);

setTimeout(() => {
el.style.opacity = '0';
setTimeout(() => el.remove(),500);
},3000);
}
});
});
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="//unpkg.com/alpinejs" defer></script>

</body>
</html>