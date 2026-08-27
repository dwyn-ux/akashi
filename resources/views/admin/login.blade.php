<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin - AKASHI 2026</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-primary via-purple-800 to-purple-950 flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-primary to-purple-700 rounded-2xl flex items-center justify-center text-3xl font-bold text-white mx-auto mb-4 shadow-lg">A</div>
                <h1 class="text-xl font-bold text-gray-800">AKASHI 2026</h1>
                <p class="text-sm text-gray-500 mt-1">Admin Panel</p>
            </div>

            <!-- Error -->
            @if($errors->any())
                <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-600 rounded-xl text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="rounded border-gray-300 text-primary focus:ring-primary">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                </div>
                <button type="submit"
                        class="w-full bg-primary hover:bg-purple-800 text-white font-semibold py-2.5 rounded-xl transition text-sm shadow-lg shadow-primary/30">
                    Masuk
                </button>
            </form>
        </div>
        <p class="text-center text-purple-300 text-xs mt-6">&copy; {{ date('Y') }} AKASHI 2026. All rights reserved.</p>
    </div>
</body>
</html>
