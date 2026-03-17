<!DOCTYPE html>
<html>
<head>

<title>Login - SILS</title>

@vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-800 min-h-screen flex items-center justify-center">

<div class="bg-white/95 backdrop-blur rounded-3xl shadow-2xl p-10 w-full max-w-md">

<h2 class="text-3xl font-bold text-center mb-2 text-gray-800">
📚 SILS
</h2>

<p class="text-gray-500 text-center mb-8">
Login to your library account
</p>


<form method="POST" action="{{ route('login') }}">

@csrf

<input
type="email"
name="email"
placeholder="Email"
class="w-full border border-gray-300 rounded-xl px-4 py-3 mb-4 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
/>

<input
type="password"
name="password"
placeholder="Password"
class="w-full border border-gray-300 rounded-xl px-4 py-3 mb-6 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
/>

<button
class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-semibold shadow-md transition">

Login

</button>

</form>

</div>

</body>
</html>