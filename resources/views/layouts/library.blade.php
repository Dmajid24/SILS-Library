<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>{{ $school->name ?? 'Library System' }}</title>

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
                {{ $school->name ?? 'Library System' }}
            </h1>
            <p class="text-xs text-gray-500">
                Smart Library
            </p>
        </div>

    </a>

    {{-- NAV --}}
    <nav class="flex items-center gap-6 text-sm font-medium">

        <a href="{{ route('dashboard') }}"
           class="text-gray-600 hover:text-indigo-600 transition">
            Dashboard
        </a>

        @if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin')
        <a href="{{ route('borrowed.index') }}"
           class="text-gray-600 hover:text-purple-600 transition">
            My Borrowed
        </a>
        @endif

        {{-- PROFILE --}}
        <div class="relative">

            <button onclick="toggleMenu()" class="flex items-center gap-2">
                <div class="w-9 h-9 bg-gradient-to-r from-indigo-600 to-purple-600 
                            text-white rounded-full flex items-center justify-center font-semibold shadow">
                    {{ strtoupper(substr(Auth::user()->first_name,0,1)) }}
                </div>
            </button>

            <div id="profileMenu"
                 class="hidden absolute right-0 mt-3 w-44 bg-white/90 backdrop-blur rounded-xl shadow-lg border border-white/50 z-[100]">

                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-2 text-sm hover:bg-indigo-50 rounded-t-xl">
                    Profile
                </a>
                
                <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="button" onclick="openLogoutModal()" 
                    class="w-full text-left px-4 py-2 text-sm hover:bg-red-50 rounded-b-xl">
                        Logout
                    </button>
                </form>

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
            <p class="font-semibold">Success</p>
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
            <p class="font-semibold">Error</p>
            <p class="text-sm">{{ session('error') }}</p>
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

        <span>{{ $school->name ?? 'School' }}</span>

    </div>

    <div class="text-center mt-2 md:mt-0">
        © {{ date('Y') }} Library System
    </div>

</div>

</footer>


{{-- ================= SCRIPT ================= --}}
<script>

function toggleMenu(){
    document.getElementById("profileMenu").classList.toggle("hidden");
}

// SHOW ALERT
window.addEventListener('DOMContentLoaded', () => {

    const success = document.getElementById('successBanner');
    const error = document.getElementById('errorBanner');

    if(success){
        setTimeout(()=>{
            success.classList.remove('opacity-0','translate-y-[-20px]');
        },100);

        setTimeout(()=>{
            success.style.opacity = '0';
            setTimeout(()=> success.remove(),500);
        },3000);
    }

    if(error){
        setTimeout(()=>{
            error.classList.remove('opacity-0','translate-y-[-20px]');
        },100);

        setTimeout(()=>{
            error.style.opacity = '0';
            setTimeout(()=> error.remove(),500);
        },3000);
    }

});

</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>