<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>
@vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center px-4 bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100">

<div class="w-full max-w-md bg-white/70 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-white/40">

<h2 class="text-2xl font-bold text-center text-gray-800 mb-2">
Reset Password 🔑
</h2>

<p class="text-center text-sm text-gray-500 mb-6">
Create a new secure password
</p>

<form method="POST" action="{{ route('password.store') }}">
@csrf

<input type="hidden" name="token" value="{{ request()->route('token') }}">

<input type="email"
name="email"
value="{{ old('email', request()->email) }}"
required
placeholder="Email"
class="w-full px-4 py-3 rounded-xl border mb-4">

<input type="password"
name="password"
required
placeholder="New Password"
class="w-full px-4 py-3 rounded-xl border mb-4">

<input type="password"
name="password_confirmation"
required
placeholder="Confirm Password"
class="w-full px-4 py-3 rounded-xl border mb-6">

<button class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-xl font-semibold shadow-lg hover:scale-[1.02] transition">
Reset Password
</button>

</form>

</div>
</body>
</html>