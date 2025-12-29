@extends('layouts.app')

@section('title', $produk->nama_produk . ' - UMKM Marketplace')
@section('meta_description', strip_tags(Str::limit($produk->deskripsi, 155)) . ' | Harga: Rp ' . number_format($produk->harga, 0, ',', '.'))
@section('meta_keywords', 'umkm, ' . strtolower($produk->nama_produk) . ', ' . ($produk->kategori ? strtolower($produk->kategori->nama_kategori) : '') . ', produk lokal, belanja online')

@section('content')
<div class="bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-purple-600 transition">🏠 Beranda</a></li>
                <li aria-hidden="true">›</li>
                @if($produk->kategori)
                    <li><span class="text-gray-700">{{ $produk->kategori->nama_kategori }}</span></li>
                    <li aria-hidden="true">›</li>
                @endif
                <li><span class="text-purple-600 font-semibold">{{ Str::limit($produk->nama_produk, 40) }}</span></li>
            </ol>
        </nav>

        <article class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="grid md:grid-cols-2 gap-8 p-8">
                {{-- Product Image --}}
                <section class="space-y-4" aria-label="Gambar Produk">
                    <div class="aspect-square bg-gradient-to-br from-purple-100 to-purple-200 rounded-xl overflow-hidden flex items-center justify-center">
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" 
                                 alt="{{ $produk->nama_produk }}"
                                 class="w-full h-full object-cover hover:scale-105 transition duration-300">
                        @else
                            <span class="text-9xl" aria-hidden="true">📦</span>
                        @endif
                    </div>
                </section>

                {{-- Product Info --}}
                <section class="space-y-6" aria-label="Informasi Produk">
                    <header>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $produk->nama_produk }}</h1>
                        
                        {{-- Category Badge --}}
                        @if($produk->kategori)
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-purple-100 text-purple-700 rounded-lg text-sm font-semibold mb-4">
                                <span aria-hidden="true">🏷️</span>
                                <span>{{ $produk->kategori->nama_kategori }}</span>
                            </div>
                        @endif

                        {{-- Price --}}
                        <div class="mb-6">
                            <p class="text-sm text-gray-600 mb-1">Harga</p>
                            <p class="text-4xl font-bold text-purple-600">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                        </div>
                    </header>

                    {{-- Stock Status --}}
                    <div class="flex items-center gap-3 pb-6 border-b border-gray-200">
                        @if($produk->stok > 0)
                            <span class="flex items-center gap-2 px-4 py-2 bg-green-50 text-green-700 rounded-lg text-sm font-semibold">
                                <span aria-hidden="true">✓</span>
                                <span>Stok Tersedia: {{ $produk->stok }} unit</span>
                            </span>
                        @else
                            <span class="flex items-center gap-2 px-4 py-2 bg-red-50 text-red-700 rounded-lg text-sm font-semibold">
                                <span aria-hidden="true">✕</span>
                                <span>Stok Habis</span>
                            </span>
                        @endif
                    </div>

                    {{-- Seller Info --}}
                    @if($produk->user)
                        <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xl">
                                {{ strtoupper(substr($produk->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-xs text-gray-600">Dijual oleh</p>
                                <p class="font-semibold text-gray-800">{{ $produk->user->name }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="space-y-3 pt-4">
                        @auth
                            @if($produk->stok > 0)
                                <a href="{{ route('checkout.show', $produk->id) }}" 
                                   class="block w-full px-8 py-4 bg-gradient-to-r from-purple-600 to-purple-800 text-white text-center text-lg font-bold rounded-xl hover:shadow-2xl transition transform hover:-translate-y-1">
                                    🛒 Checkout Sekarang
                                </a>
                            @else
                                <button disabled 
                                        class="block w-full px-8 py-4 bg-gray-300 text-gray-500 text-center text-lg font-bold rounded-xl cursor-not-allowed">
                                    Stok Habis
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" 
                               class="block w-full px-8 py-4 bg-gradient-to-r from-purple-600 to-purple-800 text-white text-center text-lg font-bold rounded-xl hover:shadow-2xl transition transform hover:-translate-y-1">
                                🛒 Login untuk Checkout
                            </a>
                        @endauth
                        
                        <a href="{{ route('home') }}" 
                           class="block w-full px-8 py-3 bg-gray-200 text-gray-700 text-center text-base font-semibold rounded-xl hover:bg-gray-300 transition">
                            ← Kembali ke Beranda
                        </a>
                    </div>
                </section>
            </div>

            {{-- Product Description --}}
            <section class="p-8 border-t border-gray-200" aria-labelledby="description-heading">
                <h2 id="description-heading" class="text-2xl font-bold text-gray-800 mb-4">Deskripsi Produk</h2>
                <div class="prose prose-purple max-w-none">
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $produk->deskripsi }}</p>
                </div>
            </section>
        </article>

        {{-- Related Products --}}
        @if($relatedProducts->count() > 0)
            <section class="mt-12" aria-labelledby="related-heading">
                <h2 id="related-heading" class="text-2xl font-bold text-gray-800 mb-6">Produk Terkait</h2>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <article class="bg-white border border-gray-200 rounded-xl hover:shadow-xl transition overflow-hidden group">
                            <a href="{{ route('produk.detail', ['id' => $related->id, 'slug' => Str::slug($related->nama_produk)]) }}">
                                <div class="aspect-square bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center overflow-hidden">
                                    @if($related->gambar)
                                        <img src="{{ asset('storage/' . $related->gambar) }}" 
                                             alt="{{ $related->nama_produk }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition">
                                    @else
                                        <span class="text-7xl" aria-hidden="true">📦</span>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="text-sm font-medium text-gray-800 mb-2 line-clamp-2 h-10">{{ $related->nama_produk }}</h3>
                                    <p class="text-lg font-bold text-purple-600 mb-2">Rp {{ number_format($related->harga, 0, ',', '.') }}</p>
                                    @if($related->stok > 0)
                                        <span class="text-xs text-green-600 font-semibold">✓ Stok: {{ $related->stok }}</span>
                                    @else
                                        <span class="text-xs text-red-600 font-semibold">✕ Stok Habis</span>
                                    @endif
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</div>
@endsection
