<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penjual - UMKM Market</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Include Sidebar -->
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="ml-64 p-8">
        @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                <div class="flex items-center">
                    <span class="text-green-500 mr-2 text-xl">✓</span>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang, {{ Auth::user()->name }}! 🎉</h2>
            <p class="text-gray-600 mb-6">Kelola toko dan produk UMKM Anda dengan mudah dari sini.</p>
            
            <!-- Stats Cards -->
            <div class="grid md:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white">
                    <div class="text-4xl mb-3">📦</div>
                    <h3 class="text-2xl font-bold mb-1">0</h3>
                    <p class="text-sm opacity-90">Total Produk</p>
                </div>
                
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white">
                    <div class="text-4xl mb-3">🛍️</div>
                    <h3 class="text-2xl font-bold mb-1">0</h3>
                    <p class="text-sm opacity-90">Pesanan Baru</p>
                </div>
                
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white">
                    <div class="text-4xl mb-3">💰</div>
                    <h3 class="text-2xl font-bold mb-1">Rp 0</h3>
                    <p class="text-sm opacity-90">Total Pendapatan</p>
                </div>
                
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-6 text-white">
                    <div class="text-4xl mb-3">⭐</div>
                    <h3 class="text-2xl font-bold mb-1">0.0</h3>
                    <p class="text-sm opacity-90">Rating Toko</p>
                </div>
            </div>
        </div>

        <!-- Menu Grid -->
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Kelola Produk -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Produk Saya</h3>
                <div class="space-y-3">
                    <a href="{{ url ('/produk/create') }}" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-purple-600 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">➕</span>
                            <div>
                                <h4 class="font-semibold text-gray-800">Tambah Produk Baru</h4>
                                <p class="text-sm text-gray-600">Upload produk baru ke toko Anda</p>
                            </div>
                        </div>
                    </a>
                    <a href="{{ url('/produk') }}" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-purple-600 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">📦</span>
                            <div>
                                <h4 class="font-semibold text-gray-800">Daftar Produk</h4>
                                <p class="text-sm text-gray-600">Lihat dan kelola semua produk Anda</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-purple-600 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">📊</span>
                            <div>
                                <h4 class="font-semibold text-gray-800">Stok Produk</h4>
                                <p class="text-sm text-gray-600">Kelola stok dan ketersediaan produk</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Kelola Pesanan -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Pesanan</h3>
                <div class="space-y-3">
                    <a href="#" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-purple-600 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">🆕</span>
                            <div>
                                <h4 class="font-semibold text-gray-800">Pesanan Baru</h4>
                                <p class="text-sm text-gray-600">Lihat dan proses pesanan masuk</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-purple-600 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">📋</span>
                            <div>
                                <h4 class="font-semibold text-gray-800">Semua Pesanan</h4>
                                <p class="text-sm text-gray-600">Riwayat semua pesanan Anda</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-purple-600 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">📦</span>
                            <div>
                                <h4 class="font-semibold text-gray-800">Pengiriman</h4>
                                <p class="text-sm text-gray-600">Kelola pengiriman produk</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Laporan & Keuangan -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Laporan & Keuangan</h3>
                <div class="space-y-3">
                    <a href="#" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-purple-600 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">💰</span>
                            <div>
                                <h4 class="font-semibold text-gray-800">Pendapatan</h4>
                                <p class="text-sm text-gray-600">Lihat total pendapatan penjualan</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-purple-600 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">📊</span>
                            <div>
                                <h4 class="font-semibold text-gray-800">Statistik Penjualan</h4>
                                <p class="text-sm text-gray-600">Analisis performa toko Anda</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-purple-600 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">📈</span>
                            <div>
                                <h4 class="font-semibold text-gray-800">Produk Terlaris</h4>
                                <p class="text-sm text-gray-600">Lihat produk yang paling laku</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Pengaturan Toko -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Pengaturan Toko</h3>
                <div class="space-y-3">
                    <a href="#" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-purple-600 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">🏪</span>
                            <div>
                                <h4 class="font-semibold text-gray-800">Profil Toko</h4>
                                <p class="text-sm text-gray-600">Edit informasi toko Anda</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-purple-600 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">⚙️</span>
                            <div>
                                <h4 class="font-semibold text-gray-800">Pengaturan</h4>
                                <p class="text-sm text-gray-600">Konfigurasi pengaturan toko</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-purple-600 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">❓</span>
                            <div>
                                <h4 class="font-semibold text-gray-800">Bantuan</h4>
                                <p class="text-sm text-gray-600">Panduan dan FAQ untuk penjual</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Aktivitas Terbaru</h3>
            <div class="text-center py-12 text-gray-400">
                <div class="text-6xl mb-4">📊</div>
                <p>Belum ada aktivitas</p>
            </div>
        </div>
    </div>
    </div>
</body>
</html>
