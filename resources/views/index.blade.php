@extends('layouts.app')

@section('title', 'UMKM Marketplace - Belanja Online Produk Lokal Indonesia')
@section('meta_description', 'Belanja produk UMKM lokal terbaik di Indonesia. Dukung ekonomi lokal dengan berbelanja produk berkualitas dari UMKM di seluruh nusantara.')
@section('meta_keywords', 'umkm, marketplace indonesia, belanja online, produk lokal, umkm indonesia, e-commerce lokal')

@push('styles')
<style>
    @keyframes slideIn {
        from { transform: translateX(100%); }
        to { transform: translateX(-100%); }
    }
    .animate-slide { animation: slideIn 20s linear infinite; }
</style>
@endpush

@section('content')

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
                <div class="product-card bg-white border border-gray-200 rounded-xl hover:shadow-xl transition overflow-hidden group" data-category="{{ $product->kategori_id }}">
                    <a href="{{ route('produk.detail', ['id' => $product->id, 'slug' => \Illuminate\Support\Str::slug($product->nama_produk)]) }}">
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
                            <div class="flex items-center gap-1 text-xs text-gray-500 mb-3">
                                <span>📦</span>
                                <span>Stok: {{ $product->stok }}</span>
                            </div>
                        </div>
                    </a>
                    <div class="px-3 pb-3">
                        @auth
                            @if($product->stok > 0 && $product->status)
                                <a href="{{ route('checkout.show', $product->id) }}" class="block w-full px-4 py-2 bg-purple-600 text-white text-center text-sm font-semibold rounded-lg hover:bg-purple-700 transition">
                                    🛒 Checkout
                                </a>
                            @else
                                <button disabled class="block w-full px-4 py-2 bg-gray-300 text-gray-500 text-center text-sm font-semibold rounded-lg cursor-not-allowed">
                                    Stok Habis
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="block w-full px-4 py-2 bg-purple-600 text-white text-center text-sm font-semibold rounded-lg hover:bg-purple-700 transition">
                                🛒 Checkout
                            </a>
                        @endauth
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

    {{-- Promo Banner --}}
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
@endsection

@push('scripts')
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
@endpush
