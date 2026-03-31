<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SILS</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gray-50 min-h-screen text-gray-800">

{{-- ================= HEADER ================= --}}
<header class="bg-white border-b">

<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

    {{-- LOGO --}}
    @if (Auth::user()->role == 'admin')
        <a href="{{ route('admin.dashboard') }}">
    @else
        <a href="{{ route('user.dashboard') }}">
    @endif

        <h1 class="font-bold text-xl text-indigo-600 tracking-wide">
            📚 SILS
        </h1>

    </a>


    {{-- NAVIGATION --}}
    <nav class="flex items-center gap-6 text-sm font-medium">

        <a href="{{ route('dashboard') }}"
           class="text-gray-600 hover:text-indigo-600 transition">
            Dashboard
        </a>

        @if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin')
        <a href="{{ route('borrowed.index') }}"
           class="text-gray-600 hover:text-indgo-600 transition">
            My Borrowed
        </a>
        @endif


        {{-- PROFILE DROPDOWN --}}
        <div class="relative">

            <button onclick="toggleMenu()" class="flex items-center gap-2">

                <div class="w-9 h-9 bg-indigo-500 text-white rounded-full flex items-center justify-center font-semibold">
                    {{ strtoupper(substr(Auth::user()->first_name,0,1)) }}
                </div>

            </button>

            <div id="profileMenu"
                 class="hidden absolute right-0 mt-3 w-44 bg-white rounded-xl shadow-sm border z-[100]">

                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-2 text-sm hover:bg-gray-50">
                    Profile
                </a>
                
               <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="button" onclick="openModal()" 
                    class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50">
                    Logout
                    </button>

                </form>
              

            </div>

        </div>

    </nav>

</div>
<div id="confirmModal" 
class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

<div class="bg-white rounded-2xl shadow-xl p-8 max-w-sm w-full text-center">

<h2 class="text-xl font-semibold mb-4">
Confirm Logout
</h2>

<p class="text-gray-600 mb-6">
Are you sure you want to logout?
</p>

<div class="flex justify-center gap-4">

<button onclick="submitLogout()" 
class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg">
Yes
</button>

<button onclick="closeModal()" 
class="bg-gray-300 hover:bg-gray-400 px-5 py-2 rounded-lg">
No
</button>

</div>

</div>
</div>


</header>


{{-- ================= MAIN CONTENT ================= --}}

<main class="max-w-7xl mx-auto px-6 py-8 space-y-6">
   @if(session('success'))

<div id="successBanner"
class="max-w-7xl mx-auto px-6 mt-6">

    <div class="bg-green-500 border border-green-600
                text-green-800 rounded-2xl
                px-6 py-4 shadow-sm
                flex items-center justify-between
                opacity-0 -translate-y-4
                transition-all duration-500">

        <div class="flex items-center gap-4">

            {{-- ICON --}}
            <div class="w-10 h-10 rounded-full
                        bg-green-100 flex items-center
                        justify-center text-lg">
                ✅
            </div>

            {{-- MESSAGE --}}
            <div>
                <p class="font-semibold">
                    Success
                </p>
                <p class="text-sm">
                    {{ session('success') }}
                </p>
            </div>

        </div>

        {{-- CLOSE BUTTON --}}
        <button onclick="closeBanner()"
            class="text-green-600 hover:text-green-800 text-xl">
            ✕
        </button>

    </div>

</div>

<script>

const banner = document.querySelector('#successBanner > div');

// show animation
setTimeout(()=>{
    banner.classList.remove('opacity-0','-translate-y-4');
},100);

// auto hide
setTimeout(closeBanner,5000);

function closeBanner(){
    banner.classList.add('opacity-0','-translate-y-4');

    setTimeout(()=>{
        document.getElementById('successBanner').remove();
    },400);
}

</script>

@endif
    @yield('content')

</main>


{{-- ================= SCRIPT ================= --}}
<script>
function toggleMenu(){
    let menu = document.getElementById("profileMenu");
    menu.classList.toggle("hidden");
}
</script>

{{-- ChartJS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

function openModal(){
    document.getElementById('confirmModal').classList.remove('hidden');
    document.getElementById('confirmModal').classList.add('flex');
}

function closeModal(){
    document.getElementById('confirmModal').classList.add('hidden');
}

function submitLogout(){
    document.getElementById('logoutForm').submit();
}
</script>

</body>
</html>