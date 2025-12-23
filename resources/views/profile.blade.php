<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - UMKM Market</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    @include('components.sidebar')

    <div class="ml-64 p-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Profil Saya</h1>
                <p class="text-gray-600">Kelola informasi profil Anda</p>
            </div>

            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <div class="flex items-center">
                        <span class="text-green-500 mr-2 text-xl">✓</span>
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <div class="flex items-center mb-2">
                        <span class="text-red-500 mr-2 text-xl">✕</span>
                        <p class="text-sm text-red-700 font-semibold">Terjadi kesalahan:</p>
                    </div>
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Profile Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <!-- Profile Header -->
                <div class="bg-gradient-to-r from-purple-600 to-purple-800 px-8 py-6">
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-4xl">
                            @if($user->role === 'admin')
                                👨‍💼
                            @elseif($user->role === 'penjual')
                                🏪
                            @else
                                👤
                            @endif
                        </div>
                        <div class="text-white">
                            <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                            <p class="text-purple-200">{{ ucfirst($user->role) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('profile.update') }}" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Nama -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('name') border-red-500 @enderror" 
                                required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('email') border-red-500 @enderror" 
                                required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- No HP -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">No. HP</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('no_hp') border-red-500 @enderror" 
                                required>
                            @error('no_hp')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                            <textarea name="alamat" rows="3" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('alamat') border-red-500 @enderror" 
                                required>{{ old('alamat', $user->alamat) }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Ubah Password</h3>
                            <p class="text-sm text-gray-600 mb-4">Kosongkan jika tidak ingin mengubah password</p>
                        </div>

                        <!-- Password Baru -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                            <input type="password" name="password" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('password') border-red-500 @enderror">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-4 pt-6">
                            <button type="submit" 
                                class="px-8 py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg hover:shadow-lg transition font-semibold">
                                💾 Simpan Perubahan
                            </button>
                            <a href="{{ route('dashboard') }}" 
                                class="px-8 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                                ← Kembali
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Info Box -->
            <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                <div class="flex items-start">
                    <span class="text-blue-500 mr-2 text-xl">ℹ️</span>
                    <div class="text-sm text-blue-700">
                        <p class="font-semibold mb-1">Informasi</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Role Anda: <strong>{{ ucfirst($user->role) }}</strong></li>
                            <li>Status Akun: <strong>{{ ucfirst($user->status) }}</strong></li>
                            @if($user->role === 'penjual')
                                <li>Status Approval: 
                                    @if($user->status_approval === 'approved')
                                        <strong class="text-green-600">Disetujui ✓</strong>
                                    @elseif($user->status_approval === 'pending')
                                        <strong class="text-yellow-600">Menunggu ⏳</strong>
                                    @else
                                        <strong class="text-red-600">Ditolak ✗</strong>
                                    @endif
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>