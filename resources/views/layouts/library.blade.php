<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SILS</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>
 @if(session('success'))

        <div id="toastSuccess"
        class="fixed bottom-6 right-6 bg-green-600 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-fade">

        <span>✅</span>
        <span>{{ session('success') }}</span>

        </div>

        <script>
        setTimeout(()=>{
            document.getElementById('toastSuccess').style.opacity = "0";
        },3000)
        </script>

    @endif
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

        @if (Auth::user()->role !== 'admin')
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