{{-- resources/views/layouts/library.blade.php --}}

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>{{ $school->name ?? __('layout.library_system') }}</title>

@vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 
             min-h-screen flex flex-col text-gray-800">

{{-- ================= HEADER ================= --}}
<header class="bg-white/70 backdrop-blur-xl border-b border-white/40 sticky top-0 z-50 shadow-sm">

<div class="w-full px-6 lg:px-10 py-4 flex justify-between items-center">

    {{-- LOGO --}}
    @if (Auth::user()->role == 'admin')
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
    @else
        <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3">
    @endif

        @if($school && $school->logo)
        <img src="{{ asset('storage/'.$school->logo) }}"
             class="w-10 h-10 object-contain rounded-xl shadow-sm">
        @endif

        <div>
            <h1 class="font-semibold leading-tight 
                       bg-gradient-to-r from-indigo-600 to-purple-600 
                       bg-clip-text text-transparent">
                {{ $school->name ?? __('layout.library_system') }}
            </h1>

            <p class="text-xs text-gray-500">
                {{ __('layout.smart_library') }}
            </p>
        </div>

    </a>

    {{-- NAV --}}
    <nav class="flex items-center gap-4 text-sm font-medium">

        <a href="{{ route('dashboard') }}"
           class="text-gray-600 hover:text-indigo-600 transition">
            {{ __('layout.dashboard') }}
        </a>

        @if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin')
        <a href="{{ route('borrowed.index') }}"
           class="text-gray-600 hover:text-purple-600 transition">
            {{ __('layout.my_borrowed') }}
        </a>
        @endif

        {{-- LANGUAGE SWITCH --}}
        <div class="flex items-center bg-gray-100 rounded-xl p-1 shadow-sm">

            <a href="{{ route('lang.switch',['locale'=>'id']) }}"
               class="px-3 py-1 rounded-lg text-xs font-semibold transition duration-200
               {{ app()->getLocale() == 'id' ? 'bg-indigo-600 text-white shadow' : 'text-gray-600 hover:bg-white' }}">
                ID
            </a>

            <a href="{{ route('lang.switch',['locale'=>'en']) }}"
               class="px-3 py-1 rounded-lg text-xs font-semibold transition duration-200
               {{ app()->getLocale() == 'en' ? 'bg-indigo-600 text-white shadow' : 'text-gray-600 hover:bg-white' }}">
                EN
            </a>

        </div>

        {{-- PROFILE --}}
        <div class="relative">

            <button onclick="toggleMenu()" class="flex items-center gap-2">
                <div class="w-9 h-9 bg-gradient-to-r from-indigo-600 to-purple-600 
                            text-white rounded-full flex items-center justify-center font-semibold shadow">
                    {{ strtoupper(substr(Auth::user()->first_name ?? Auth::user()->name,0,1)) }}
                </div>
            </button>

            <div id="profileMenu"
                 class="hidden absolute right-0 mt-3 w-44 bg-white/90 backdrop-blur rounded-xl shadow-lg border border-white/50 z-[100]">

                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-2 text-sm hover:bg-indigo-50 rounded-t-xl">
                    {{ __('layout.profile') }}
                </a>
                
                <button type="button" onclick="openLogoutModal()" 
                class="w-full text-left px-4 py-2 text-sm hover:bg-red-50 rounded-b-xl">
                    {{ __('layout.logout') }}
                </button>

            </div>

        </div>

    </nav>

</div>
</header>


{{-- ================= MAIN ================= --}}
<main class="flex-1 w-full px-6 lg:px-10 py-8 space-y-6">

{{-- SUCCESS --}}
@if(session('success'))
<div id="successBanner"
class="fixed top-5 right-5 z-[9999] 
       bg-green-500 text-white px-6 py-4 rounded-2xl shadow-lg
       opacity-0 translate-y-[-20px] transition-all duration-500">

    <div class="flex items-center gap-3">
        <span>🎉</span>
        <div>
            <p class="font-semibold">{{ __('layout.success') }}</p>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
    </div>

</div>
@endif


{{-- ERROR --}}
@if(session('error'))
<div id="errorBanner"
class="fixed top-5 right-5 z-[9999] 
       bg-red-500 text-white px-6 py-4 rounded-2xl shadow-lg
       opacity-0 translate-y-[-20px] transition-all duration-500">

    <div class="flex items-center gap-3">
        <span>⚠️</span>
        <div>
            <p class="font-semibold">{{ __('layout.error') }}</p>
            <p class="text-sm">{{ session('error') }}</p>
        </div>
    </div>

</div>
@endif

{{-- VALIDATION ERROR --}}
@if ($errors->any())
<div id="validationBanner"
class="fixed top-5 right-5 z-[9999] 
       bg-red-500 text-white px-6 py-4 rounded-2xl shadow-lg
       opacity-0 translate-y-[-20px] transition-all duration-500">

    <div class="flex items-start gap-3">
        <span>⚠️</span>
        <div>
            <p class="font-semibold">{{ __('layout.validation_error') }}</p>

            <ul class="text-sm mt-1">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>

        </div>
    </div>

</div>
@endif

@yield('content')

</main>


{{-- ================= FOOTER ================= --}}
<footer class="bg-white/70 backdrop-blur border-t border-white/40">

<div class="w-full px-6 lg:px-10 py-6 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">

    <div class="flex items-center gap-2">

        @if($school && $school->logo)
        <img src="{{ asset('storage/'.$school->logo) }}"
             class="w-6 h-6 object-contain">
        @endif

        <span>{{ $school->name ?? __('layout.school') }}</span>

    </div>

    <div class="text-center mt-2 md:mt-0">
        © {{ date('Y') }} {{ __('layout.library_system') }}
    </div>

</div>

</footer>


{{-- ================= LOGOUT FORM ================= --}}
<form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>


{{-- ================= LOGOUT MODAL ================= --}}
<div id="logoutModal"
     class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-[9999]">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">

        <h2 class="text-lg font-semibold text-gray-800 mb-2">
            {{ __('layout.confirm_logout') }}
        </h2>

        <p class="text-sm text-gray-500 mb-6">
            {{ __('layout.logout_question') }}
        </p>

        <div class="flex justify-end gap-3">

            <button onclick="closeLogoutModal()"
            class="px-4 py-2 rounded-xl border text-gray-600 hover:bg-gray-100">
                {{ __('layout.cancel') }}
            </button>

            <button onclick="submitLogout()"
            class="px-4 py-2 rounded-xl bg-red-500 text-white hover:bg-red-600">
                {{ __('layout.yes_logout') }}
            </button>

        </div>

    </div>

</div>


{{-- ================= SCRIPT ================= --}}
<script>

function toggleMenu(){
    document.getElementById("profileMenu").classList.toggle("hidden");
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


// ALERT ANIMATION
window.addEventListener('DOMContentLoaded', () => {

    const success = document.getElementById('successBanner');
    const error = document.getElementById('errorBanner');
    const validation = document.getElementById('validationBanner');

    [success,error,validation].forEach(el => {

        if(el){

            setTimeout(()=>{
                el.classList.remove('opacity-0','translate-y-[-20px]');
            },100);

            setTimeout(()=>{
                el.style.opacity = '0';
                setTimeout(()=> el.remove(),500);
            },3000);

        }

    });

});
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>