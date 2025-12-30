<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - UMKM Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-600 to-purple-800 min-h-screen flex items-center justify-center p-3 sm:p-5">
    <div class="flex flex-col lg:flex-row max-w-4xl w-full bg-white rounded-xl lg:rounded-2xl overflow-hidden shadow-2xl">
        <!-- Left Section -->
        <div class="hidden lg:flex flex-1 bg-gradient-to-br from-purple-600 to-purple-800 p-8 xl:p-12 text-white flex-col justify-center">
            <div class="text-2xl xl:text-3xl font-bold mb-4 lg:mb-5 flex items-center gap-2">
                <span class="text-3xl xl:text-4xl">🛒</span>
                UMKM Market
            </div>
            <h2 class="text-2xl xl:text-3xl font-bold mb-3 lg:mb-4">Mulai Berjualan Sekarang!</h2>
            <p class="text-sm xl:text-base opacity-90 leading-relaxed">
                Daftarkan bisnis UMKM Anda dan jangkau jutaan pembeli di seluruh Indonesia. Proses pendaftaran mudah dan cepat!
            </p>
            <div class="mt-8 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center text-sm font-bold">✓</div>
                    <span>Gratis biaya pendaftaran</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center text-sm font-bold">✓</div>
                    <span>Dashboard lengkap & mudah digunakan</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center text-sm font-bold">✓</div>
                    <span>Dukungan pelanggan 24/7</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center text-sm font-bold">✓</div>
                    <span>Sistem pembayaran aman & terpercaya</span>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="flex-1 p-6 sm:p-8 lg:p-10 xl:p-12 overflow-y-auto max-h-screen">
            <!-- Mobile Logo -->
            <div class="lg:hidden text-center mb-6">
                <div class="text-2xl font-bold text-purple-600 flex items-center justify-center gap-2">
                    <span class="text-3xl">🛒</span>
                    UMKM Market
                </div>
            </div>
            
            <div class="mb-6 sm:mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Buat Akun Baru</h1>
                <p class="text-gray-600 text-xs sm:text-sm">Lengkapi formulir di bawah untuk mendaftar</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 sm:mb-5 bg-red-50 border-l-4 border-red-500 p-3 sm:p-4 rounded">
                    <div class="flex items-start">
                        <span class="text-red-500 mr-2 mt-0.5 text-lg sm:text-xl">⚠️</span>
                        <div class="text-xs sm:text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <p class="mb-1">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <div class="mb-4 sm:mb-5">
                    <label for="name" class="block mb-1.5 sm:mb-2 text-gray-700 font-medium text-xs sm:text-sm">Nama Lengkap</label>
                    <input 
                        type="text" 
                        name="name"
                        id="name" 
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap Anda" 
                        required
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg text-xs sm:text-sm focus:outline-none focus:border-purple-600 focus:ring-2 sm:focus:ring-4 focus:ring-purple-100 transition @error('name') border-red-500 @enderror"
                    >
                </div>

                <div class="mb-4 sm:mb-5">
                    <label for="email" class="block mb-1.5 sm:mb-2 text-gray-700 font-medium text-xs sm:text-sm">Email</label>
                    <input 
                        type="email" 
                        name="email"
                        id="email" 
                        value="{{ old('email') }}"
                        placeholder="nama@email.com" 
                        required
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg text-xs sm:text-sm focus:outline-none focus:border-purple-600 focus:ring-2 sm:focus:ring-4 focus:ring-purple-100 transition @error('email') border-red-500 @enderror"
                    >
                </div>

                <div class="mb-4 sm:mb-5">
                    <label for="no_hp" class="block mb-1.5 sm:mb-2 text-gray-700 font-medium text-xs sm:text-sm">Nomor HP/WhatsApp</label>
                    <input 
                        type="tel" 
                        name="no_hp"
                        id="no_hp" 
                        value="{{ old('no_hp') }}"
                        placeholder="08xxxxxxxxxx" 
                        required
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg text-xs sm:text-sm focus:outline-none focus:border-purple-600 focus:ring-2 sm:focus:ring-4 focus:ring-purple-100 transition @error('no_hp') border-red-500 @enderror"
                    >
                </div>

                <div class="mb-4 sm:mb-5">
                    <label for="alamat" class="block mb-1.5 sm:mb-2 text-gray-700 font-medium text-xs sm:text-sm">Alamat Lengkap</label>
                    <textarea 
                        name="alamat"
                        id="alamat" 
                        rows="3"
                        placeholder="Masukkan alamat lengkap Anda"
                        required
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg text-xs sm:text-sm focus:outline-none focus:border-purple-600 focus:ring-2 sm:focus:ring-4 focus:ring-purple-100 transition @error('alamat') border-red-500 @enderror"
                    >{{ old('alamat') }}</textarea>
                </div>

                <div class="mb-4 sm:mb-5">
                    <label for="password" class="block mb-1.5 sm:mb-2 text-gray-700 font-medium text-xs sm:text-sm">Password</label>
                    <input 
                        type="password" 
                        name="password"
                        id="password" 
                        placeholder="Minimal 6 karakter" 
                        required
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg text-xs sm:text-sm focus:outline-none focus:border-purple-600 focus:ring-2 sm:focus:ring-4 focus:ring-purple-100 transition @error('password') border-red-500 @enderror"
                    >
                </div>

                <div class="mb-4 sm:mb-5">
                    <label for="password_confirmation" class="block mb-1.5 sm:mb-2 text-gray-700 font-medium text-xs sm:text-sm">Konfirmasi Password</label>
                    <input 
                        type="password" 
                        name="password_confirmation"
                        id="password_confirmation" 
                        placeholder="Masukkan ulang password" 
                        required
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg text-xs sm:text-sm focus:outline-none focus:border-purple-600 focus:ring-2 sm:focus:ring-4 focus:ring-purple-100 transition"
                    >
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-purple-600 to-purple-800 text-white py-2.5 sm:py-3 rounded-lg text-sm sm:text-base font-semibold hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition transform"
                >
                    Daftar Sekarang
                </button>
            </form>

            <div class="relative my-5 sm:my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-xs sm:text-sm">
                    <span class="px-3 sm:px-4 bg-white text-gray-500">atau daftar dengan</span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 mb-5 sm:mb-6">
                <button 
                    onclick="alert('Daftar dengan Google akan segera tersedia!')"
                    class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg bg-white text-xs sm:text-sm hover:border-purple-600 hover:bg-purple-50 transition"
                >
                    <span>🔍</span> Google
                </button>
                <button 
                    onclick="alert('Daftar dengan Facebook akan segera tersedia!')"
                    class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg bg-white text-xs sm:text-sm hover:border-purple-600 hover:bg-purple-50 transition"
                >
                    <span>📘</span> Facebook
                </button>
            </div>

            <div class="text-center text-gray-600 text-xs sm:text-sm">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-purple-600 font-semibold hover:underline">
                    Masuk Sekarang
                </a>
            </div>
        </div>
    </div>
</body>
</html>
