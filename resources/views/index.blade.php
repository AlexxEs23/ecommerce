<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMKM Marketplace - Belanja Online Produk Lokal Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes slideIn {
            from { transform: translateX(100%); }
            to { transform: translateX(-100%); }
        }
        .animate-slide { animation: slideIn 20s linear infinite; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    
    <!-- Top Bar -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white text-sm py-2">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <span>📱 Download Aplikasi</span>
                <span>|</span>
                <span>Ikuti Kami: 📘 📷 🐦</span>
            </div>
            <div class="flex items-center gap-4">
                <span>🔔 Notifikasi</span>
                <span>❓ Bantuan</span>
            </div>
        </div>
    </div>

    <!-- Main Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <span class="text-3xl">🛒</span>
                    <h1 class="text-2xl font-bold text-purple-700">UMKM Market</h1>
                </div>
                
                <!-- Search Bar -->
                <div class="flex-1 max-w-2xl mx-8">
                    <div class="relative">
                        <input type="text" placeholder="Cari produk, toko, atau kategori..." 
                               class="w-full px-4 py-2 pr-12 border-2 border-purple-600 rounded-lg focus:outline-none focus:border-purple-700">
                        <button class="absolute right-0 top-0 h-full px-6 bg-purple-600 text-white rounded-r-lg hover:bg-purple-700 transition">
                            🔍
                        </button>
                    </div>
                </div>
                
                <!-- Right Menu -->
                <div class="flex items-center gap-4">
                    <button class="relative">
                        <span class="text-2xl">🛒</span>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                    </button>
                    
                    @guest
                        <a href="{{ url('/login') }}" class="px-4 py-2 text-purple-600 border-2 border-purple-600 rounded-lg hover:bg-purple-50 transition font-medium">
                            Masuk
                        </a>
                        <a href="{{ url('/register') }}" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg hover:shadow-lg transition font-medium">
                            Daftar
                        </a>
                    @else
                        
                        <div class="flex items-center gap-2">
                            <span class="text-gray-700 font-medium">👤 {{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-medium">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    @endguest
                </div>
            </div>
            
            <!-- Category Menu -->
            <div class="border-t border-gray-200 py-3">
                <div class="flex items-center gap-6 text-sm">
                    <a href="#" class="text-gray-700 hover:text-purple-600 transition font-medium">🏠 Semua Kategori</a>
                    <a href="#" class="text-gray-700 hover:text-purple-600 transition">👕 Fashion</a>
                    <a href="#" class="text-gray-700 hover:text-purple-600 transition">🍽️ Makanan</a>
                    <a href="#" class="text-gray-700 hover:text-purple-600 transition">🎨 Kerajinan</a>
                    <a href="#" class="text-gray-700 hover:text-purple-600 transition">💄 Kecantikan</a>
                    <a href="#" class="text-gray-700 hover:text-purple-600 transition">📚 Buku</a>
                    <a href="#" class="text-gray-700 hover:text-purple-600 transition">⚡ Elektronik</a>
                    <a href="#" class="text-purple-600 font-medium">🔥 Promo Hari Ini</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Banner Carousel -->
    <section class="bg-gray-100 py-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800 rounded-2xl overflow-hidden shadow-xl">
                <div class="flex items-center justify-between p-12">
                    <div class="text-white max-w-xl">
                        <h2 class="text-4xl font-bold mb-4">Flash Sale Hari Ini!</h2>
                        <p class="text-xl mb-6">Diskon hingga 70% untuk produk pilihan</p>
                        <button class="px-8 py-3 bg-yellow-400 text-purple-900 rounded-lg font-bold text-lg hover:bg-yellow-300 transition">
                            Belanja Sekarang
                        </button>
                    </div>
                    <div class="text-8xl">🎉</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Shortcuts -->
    <section class="bg-white py-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center overflow-x-auto gap-4 pb-2">
                <div class="flex flex-col items-center min-w-[80px] cursor-pointer hover:scale-110 transition">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center mb-2 shadow-lg">
                        <span class="text-2xl">👕</span>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Fashion</span>
                </div>
                <div class="flex flex-col items-center min-w-[80px] cursor-pointer hover:scale-110 transition">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center mb-2 shadow-lg">
                        <span class="text-2xl">🍽️</span>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Makanan</span>
                </div>
                <div class="flex flex-col items-center min-w-[80px] cursor-pointer hover:scale-110 transition">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-400 to-pink-600 rounded-full flex items-center justify-center mb-2 shadow-lg">
                        <span class="text-2xl">💄</span>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Kecantikan</span>
                </div>
                <div class="flex flex-col items-center min-w-[80px] cursor-pointer hover:scale-110 transition">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mb-2 shadow-lg">
                        <span class="text-2xl">⚡</span>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Elektronik</span>
                </div>
                <div class="flex flex-col items-center min-w-[80px] cursor-pointer hover:scale-110 transition">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mb-2 shadow-lg">
                        <span class="text-2xl">🎨</span>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Kerajinan</span>
                </div>
                <div class="flex flex-col items-center min-w-[80px] cursor-pointer hover:scale-110 transition">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center mb-2 shadow-lg">
                        <span class="text-2xl">🏠</span>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Rumah</span>
                </div>
                <div class="flex flex-col items-center min-w-[80px] cursor-pointer hover:scale-110 transition">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-full flex items-center justify-center mb-2 shadow-lg">
                        <span class="text-2xl">📚</span>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Buku</span>
                </div>
                <div class="flex flex-col items-center min-w-[80px] cursor-pointer hover:scale-110 transition">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-400 to-red-600 rounded-full flex items-center justify-center mb-2 shadow-lg">
                        <span class="text-2xl">🎮</span>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Hobi</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Flash Sale Section -->
    <section class="bg-gradient-to-br from-purple-50 to-purple-100 py-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <h2 class="text-3xl font-bold text-gray-800">⚡ Flash Sale</h2>
                    <div class="bg-red-500 text-white px-4 py-2 rounded-lg font-bold">
                        Berakhir dalam: 02:45:30
                    </div>
                </div>
                <a href="#" class="text-purple-600 font-semibold hover:text-purple-700">Lihat Semua →</a>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @forelse($flashSaleProducts as $product)
                <!-- Product Card -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition cursor-pointer overflow-hidden group">
                    <div class="relative">
                        <div class="aspect-square bg-gray-200 flex items-center justify-center overflow-hidden">
                            @if($product->gambar)
                                <img src="{{ asset('storage/' . $product->gambar) }}" 
                                     alt="{{ $product->nama_produk }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition">
                            @else
                                <div class="text-6xl group-hover:scale-110 transition">📦</div>
                            @endif
                        </div>
                        <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                            SALE
                        </div>
                    </div>
                    <div class="p-3">
                        <h3 class="text-sm font-semibold text-gray-800 mb-1 line-clamp-2">{{ $product->nama_produk }}</h3>
                        <div class="flex items-center gap-1 mb-2">
                            <span class="text-yellow-400">⭐</span>
                            <span class="text-xs text-gray-600">{{ $product->kategori->nama_kategori ?? 'Umum' }}</span>
                        </div>
                        <span class="text-lg font-bold text-purple-600">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                        <div class="mt-1 text-xs text-gray-500">
                            Stok: {{ $product->stok }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-6 text-center py-8 text-gray-500">
                    Belum ada produk flash sale
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Recommended Products -->
    <section class="bg-white py-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800">Rekomendasi Untuk Anda</h2>
                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium">Semua</button>
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Terlaris</button>
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Terbaru</button>
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Termurah</button>
                </div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @forelse($recommendedProducts as $product)
                <!-- Product -->
                <div class="bg-white border border-gray-200 rounded-xl hover:shadow-xl transition cursor-pointer overflow-hidden group">
                    <div class="relative">
                        <div class="aspect-square bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center overflow-hidden">
                            @if($product->gambar)
                                <img src="{{ asset('storage/' . $product->gambar) }}" 
                                     alt="{{ $product->nama_produk }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition">
                            @else
                                <div class="text-7xl group-hover:scale-105 transition">📦</div>
                            @endif
                        </div>
                    </div>
                    <div class="p-3">
                        <h3 class="text-sm font-medium text-gray-800 mb-1 line-clamp-2 h-10">{{ $product->nama_produk }}</h3>
                        <div class="flex items-center gap-1 mb-2">
                            <span class="text-yellow-400 text-sm">⭐</span>
                            <span class="text-xs text-gray-600">{{ $product->kategori->nama_kategori ?? 'Umum' }}</span>
                        </div>
                        <div class="flex items-baseline gap-2 mb-2">
                            <span class="text-lg font-bold text-purple-600">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center gap-1 text-xs text-gray-500">
                            <span>📦</span>
                            <span>Stok: {{ $product->stok }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-5 text-center py-8 text-gray-500">
                    Belum ada produk rekomendasi
                </div>
                @endforelse
            </div>

            <!-- Load More Button -->
            <div class="text-center mt-8">
                <button class="px-8 py-3 border-2 border-purple-600 text-purple-600 rounded-lg font-semibold hover:bg-purple-50 transition">
                    Muat Lebih Banyak Produk
                </button>
            </div>
        </div>
    </section>

    <!-- Promo Banner -->
    <section class="bg-gradient-to-r from-purple-600 to-purple-800 py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between text-white">
                <div>
                    <h2 class="text-3xl font-bold mb-2">🎉 Jadi Seller Sekarang!</h2>
                    <p class="text-lg opacity-90">Mulai bisnis online Anda bersama ribuan UMKM Indonesia lainnya</p>
                </div>
                <a href="/auth/register" class="px-8 py-4 bg-yellow-400 text-purple-900 rounded-lg font-bold text-lg hover:bg-yellow-300 hover:shadow-xl transition transform hover:-translate-y-1">
                    Daftar Gratis
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-5 gap-8 mb-8">
                <!-- Brand -->
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-3xl">🛒</span>
                        <h3 class="text-2xl font-bold">UMKM Market</h3>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Platform marketplace terpercaya untuk UMKM Indonesia. Belanja produk lokal berkualitas dengan harga terbaik.
                    </p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center hover:bg-purple-700 transition">
                            <span>📘</span>
                        </a>
                        <a href="#" class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center hover:bg-purple-700 transition">
                            <span>📷</span>
                        </a>
                        <a href="#" class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center hover:bg-purple-700 transition">
                            <span>🐦</span>
                        </a>
                        <a href="#" class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center hover:bg-purple-700 transition">
                            <span>📱</span>
                        </a>
                    </div>
                </div>
                
                <!-- Tentang -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Tentang Kami</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Tentang UMKM Market</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Karir</a></li>
                        <li><a href="#" class="hover:text-white transition">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-white transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                
                <!-- Bantuan -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Bantuan</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-white transition">Cara Berbelanja</a></li>
                        <li><a href="#" class="hover:text-white transition">Cara Berjualan</a></li>
                        <li><a href="#" class="hover:text-white transition">Pembayaran</a></li>
                        <li><a href="#" class="hover:text-white transition">Pengiriman</a></li>
                    </ul>
                </div>
                
                <!-- Lainnya -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Lainnya</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Jual di UMKM Market</a></li>
                        <li><a href="#" class="hover:text-white transition">Flash Sale</a></li>
                        <li><a href="#" class="hover:text-white transition">Promosi</a></li>
                        <li><a href="#" class="hover:text-white transition">Lacak Pesanan</a></li>
                        <li><a href="#" class="hover:text-white transition">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Payment Methods -->
            <div class="border-t border-gray-800 pt-8 mb-8">
                <h4 class="font-bold text-lg mb-4">Metode Pembayaran</h4>
                <div class="flex flex-wrap gap-3">
                    <div class="bg-white px-4 py-2 rounded-lg text-sm font-semibold text-gray-700">💳 Bank Transfer</div>
                    <div class="bg-white px-4 py-2 rounded-lg text-sm font-semibold text-gray-700">💰 E-Wallet</div>
                    <div class="bg-white px-4 py-2 rounded-lg text-sm font-semibold text-gray-700">🏪 Minimarket</div>
                    <div class="bg-white px-4 py-2 rounded-lg text-sm font-semibold text-gray-700">📱 QRIS</div>
                </div>
            </div>

            <!-- Shipping -->
            <div class="border-t border-gray-800 pt-8 mb-8">
                <h4 class="font-bold text-lg mb-4">Jasa Pengiriman</h4>
                <div class="flex flex-wrap gap-3">
                    <div class="bg-white px-4 py-2 rounded-lg text-sm font-semibold text-gray-700">📦 JNE</div>
                    <div class="bg-white px-4 py-2 rounded-lg text-sm font-semibold text-gray-700">🚚 J&T</div>
                    <div class="bg-white px-4 py-2 rounded-lg text-sm font-semibold text-gray-700">🚛 SiCepat</div>
                    <div class="bg-white px-4 py-2 rounded-lg text-sm font-semibold text-gray-700">📮 POS Indonesia</div>
                    <div class="bg-white px-4 py-2 rounded-lg text-sm font-semibold text-gray-700">🏍️ GoSend</div>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2024 UMKM Market. All Rights Reserved. Made with ❤️ for Indonesian UMKM</p>
            </div>
        </div>
    </footer>

</body>
</html>
