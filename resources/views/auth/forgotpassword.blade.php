<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - UMKM Market</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-50 via-white to-purple-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo/Brand -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent mb-2">
                    🛒 UMKM Market
                </h1>
            </a>
            <p class="text-gray-600">Platform Belanja UMKM Indonesia</p>
        </div>

        <!-- Forgot Password Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <div class="text-center mb-6">
                <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-4xl">🔐</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Lupa Password?</h2>
                <p class="text-gray-600 text-sm">
                    Masukkan email Anda dan kami akan mengirimkan link untuk reset password
                </p>
            </div>

            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <div class="flex items-center">
                        <span class="text-green-500 mr-2 text-xl">✓</span>
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <div class="flex items-center">
                        <span class="text-red-500 mr-2 text-xl">✕</span>
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            {{-- <form action="{{ route('forgot.password.post') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            📧
                        </span>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:outline-none transition @error('email') border-red-500 @enderror" 
                            placeholder="nama@email.com"
                            required
                            autofocus
                        >
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-purple-600 to-purple-700 text-white font-bold py-3 rounded-lg hover:from-purple-700 hover:to-purple-800 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                >
                    Kirim Link Reset Password
                </button>
            </form> --}}

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <p class="text-gray-600 text-sm">
                    Ingat password Anda? 
                    <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-700 font-semibold hover:underline">
                        Kembali ke Login
                    </a>
                </p>
            </div>
        </div>

        <!-- Additional Help -->
        <div class="mt-6 text-center">
            <p class="text-gray-600 text-sm">
                Butuh bantuan? 
                <a href="#" class="text-purple-600 hover:text-purple-700 font-semibold">
                    Hubungi Support
                </a>
            </p>
        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <span class="text-2xl mr-3">ℹ️</span>
                <div>
                    <h4 class="font-semibold text-blue-900 mb-1">Catatan Keamanan</h4>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Link reset password hanya berlaku 60 menit</li>
                        <li>• Periksa folder spam jika email tidak masuk</li>
                        <li>• Jangan bagikan link reset ke siapapun</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
