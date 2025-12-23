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
                        <div class="relative group">
                            <button class="flex items-center gap-2 px-4 py-2 bg-purple-100 rounded-lg hover:bg-purple-200 transition">
                                <span class="text-2xl">👤</span>
                                <div class="text-left">
                                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-600">{{ ucfirst(Auth::user()->role) }}</p>
                                </div>
                                <span class="text-gray-500">▼</span>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <div class="py-2">
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-purple-50 transition">
                                        <span class="text-xl">📊</span>
                                        <span class="text-gray-700">Dashboard</span>
                                    </a>
                                    <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-purple-50 transition">
                                        <span class="text-xl">👤</span>
                                        <span class="text-gray-700">Profil Saya</span>
                                    </a>
                                    @if(Auth::user()->role === 'penjual' && Auth::user()->status_approval === 'approved')
                                        <a href="{{ route('produk.index') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-purple-50 transition">
                                            <span class="text-xl">📦</span>
                                            <span class="text-gray-700">Produk Saya</span>
                                        </a>
                                    @endif
                                    <hr class="my-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-red-50 text-red-600 transition">
                                            <span class="text-xl">🚪</span>
                                            <span>Keluar</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
            
            <!-- Category Menu -->
            <div class="border-t border-gray-200 py-3">
                <div class="flex items-center gap-6 text-sm overflow-x-auto">
                    <a href="#" class="text-gray-700 hover:text-purple-600 transition font-medium whitespace-nowrap">🏠 Semua Kategori</a>
                    @foreach($categories as $category)
                        <a href="#" class="text-gray-700 hover:text-purple-600 transition whitespace-nowrap">{{ $category->nama_kategori }}</a>
                    @endforeach
                    <a href="#" class="text-purple-600 font-medium whitespace-nowrap">🔥 Promo Hari Ini</a>
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
    <section class="bg-white py-12 relative overflow-hidden">
        <!-- Decorative Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-purple-50 via-white to-blue-50 opacity-60"></div>
        
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Belanja Berdasarkan Kategori</h2>
                <p class="text-gray-600">Temukan produk UMKM terbaik sesuai kebutuhan Anda</p>
            </div>
            
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-8 xl:grid-cols-10 gap-6">
                <!-- Tombol Semua -->
                <button onclick="filterCategory('all')" class="group category-btn" data-category="all">
                    <div class="bg-white rounded-2xl p-4 transition-all duration-300 hover:shadow-xl hover:-translate-y-2 border-2 border-purple-600">
                        <div class="w-16 h-16 mx-auto bg-gradient-to-br from-gray-500 to-gray-600 rounded-2xl flex items-center justify-center mb-3 shadow-lg shadow-gray-200 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <span class="text-3xl transform group-hover:scale-110 transition-transform duration-300">🏠</span>
                        </div>
                        <p class="text-xs font-semibold text-gray-700 text-center leading-tight group-hover:text-purple-600 transition-colors">Semua</p>
                    </div>
                </button>
                
                @foreach($categories as $index => $category)
                <button onclick="filterCategory({{ $category->id }})" class="group category-btn" data-category="{{ $category->id }}">
                    <div class="bg-white rounded-2xl p-4 transition-all duration-300 hover:shadow-xl hover:-translate-y-2 border border-gray-100">
                        @php
                            $colors = ['from-purple-500 to-purple-600', 'from-orange-500 to-orange-600', 'from-pink-500 to-pink-600', 'from-blue-500 to-blue-600', 'from-green-500 to-green-600', 'from-yellow-500 to-yellow-600', 'from-indigo-500 to-indigo-600', 'from-red-500 to-red-600', 'from-teal-500 to-teal-600', 'from-cyan-500 to-cyan-600'];
                            $shadows = ['shadow-purple-200', 'shadow-orange-200', 'shadow-pink-200', 'shadow-blue-200', 'shadow-green-200', 'shadow-yellow-200', 'shadow-indigo-200', 'shadow-red-200', 'shadow-teal-200', 'shadow-cyan-200'];
                            $colorBg = $colors[$index % count($colors)];
                            $colorShadow = $shadows[$index % count($shadows)];
                            
                            $icons = ['Fashion' => '👕', 'Makanan' => '🍽️', 'Kerajinan' => '🎨', 'Kecantikan' => '💄', 'Buku' => '📚', 'Elektronik' => '⚡', 'Rumah Tangga' => '🏠', 'Olahraga' => '⚽', 'Hobi' => '🎮', 'Otomotif' => '🚗'];
                            $icon = $icons[$category->nama_kategori] ?? '📦';
                        @endphp
                        <div class="w-16 h-16 mx-auto bg-gradient-to-br {{ $colorBg }} rounded-2xl flex items-center justify-center mb-3 shadow-lg {{ $colorShadow }} group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <span class="text-3xl transform group-hover:scale-110 transition-transform duration-300">{{ $icon }}</span>
                        </div>
                        <p class="text-xs font-semibold text-gray-700 text-center leading-tight group-hover:text-purple-600 transition-colors">{{ $category->nama_kategori }}</p>
                    </div>
                </button>
                @endforeach
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
                <div class="product-card bg-white border border-gray-200 rounded-xl hover:shadow-xl transition cursor-pointer overflow-hidden group" data-category="{{ $product->kategori_id }}">
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
                <a href="{{ route('register') }}" class="px-8 py-4 bg-yellow-400 text-purple-900 rounded-lg font-bold text-lg hover:bg-yellow-300 hover:shadow-xl transition transform hover:-translate-y-1">
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
            
            <!-- Copyright -->
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2024 UMKM Market. All Rights Reserved. Made with ❤️ for Indonesian UMKM</p>
            </div>
        </div>
    </footer>

    <script>
        function filterCategory(categoryId) {
            // Update active button
            document.querySelectorAll('.category-btn').forEach(btn => {
                if (btn.dataset.category == categoryId) {
                    btn.querySelector('div').classList.add('border-2', 'border-purple-600', 'shadow-2xl');
                    btn.querySelector('div').classList.remove('border-gray-100');
                } else {
                    btn.querySelector('div').classList.remove('border-2', 'border-purple-600', 'shadow-2xl');
                    btn.querySelector('div').classList.add('border-gray-100');
                }
            });
            
            // Filter products
            const products = document.querySelectorAll('.product-card');
            let visibleCount = 0;
            
            products.forEach(product => {
                const productCategory = product.dataset.category;
                
                if (categoryId === 'all' || productCategory == categoryId) {
                    product.style.display = 'block';
                    visibleCount++;
                } else {
                    product.style.display = 'none';
                }
            });
            
            // Show message if no products
            console.log('Filtered:', visibleCount, 'products for category:', categoryId);
        }
    </script>
</body>
</html>
