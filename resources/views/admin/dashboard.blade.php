@extends('layouts.dashboard')

@section('title', 'Dashboard Admin - UMKM Marketplace')
@section('meta_description', 'Dashboard administrator untuk mengelola seluruh sistem UMKM Marketplace Indonesia')

@section('content')
<header class="bg-white rounded-xl shadow-lg p-8 mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Administrator</h1>
    <p class="text-gray-600">Kelola seluruh sistem UMKM Market dari sini</p>
</header>

{{-- Stats Cards --}}
<section class="mb-8" aria-label="Statistik Ringkasan">
    <div class="grid md:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white">
                    <div class="flex justify-between items-start mb-4">
                        <div class="text-4xl">👥</div>
                        <span class="bg-white/20 px-2 py-1 rounded text-xs">Total</span>
                    </div>
                    <h3 class="text-3xl font-bold mb-1">{{ \App\Models\User::count() }}</h3>
                    <p class="text-sm opacity-90">Total Pengguna</p>
                </div>
                
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white">
                    <div class="flex justify-between items-start mb-4">
                        <div class="text-4xl">🏪</div>
                        <span class="bg-white/20 px-2 py-1 rounded text-xs">Aktif</span>
                    </div>
                    <h3 class="text-3xl font-bold mb-1">{{ \App\Models\User::where('role', 'penjual')->count() }}</h3>
                    <p class="text-sm opacity-90">Total Penjual</p>
                </div>
                
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white">
                    <div class="flex justify-between items-start mb-4">
                        <div class="text-4xl">📦</div>
                        <span class="bg-white/20 px-2 py-1 rounded text-xs">Items</span>
                    </div>
                    <h3 class="text-3xl font-bold mb-1">{{ \App\Models\Produk::count() }}</h3>
                    <p class="text-sm opacity-90">Total Produk</p>
                </div>
                
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-6 text-white">
                    <div class="flex justify-between items-start mb-4">
                        <div class="text-4xl">🛍️</div>
                        <span class="bg-white/20 px-2 py-1 rounded text-xs">Orders</span>
                    </div>
                    <h3 class="text-3xl font-bold mb-1">{{ \App\Models\Pesanan::count() }}</h3>
                    <p class="text-sm opacity-90">Total Pesanan</p>
        </div>
    </div>
</section>

{{-- Menu Grid --}}
<section class="mb-8" aria-label="Menu Navigasi Admin">
    <div class="grid md:grid-cols-3 gap-6">
            {{-- Kelola User --}}
            <article class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition">
                <div class="text-5xl mb-4">👥</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Kelola Pengguna</h3>
                <p class="text-gray-600 mb-4 text-sm">Manage semua user, penjual dan admin</p>
                <a href="{{ route('admin.users.index') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-semibold">
                    Lihat Pengguna
                </a>
            </article>

            {{-- Kelola Produk --}}
            <article class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition">
                <div class="text-5xl mb-4">📦</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Kelola Produk</h3>
                <p class="text-gray-600 mb-4 text-sm">Monitor dan moderasi semua produk</p>
                <a href="{{ url ('/produk') }}" class="inline-block px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-semibold">
                    Lihat Produk
                </a>
            </article>

            {{-- Kelola Pesanan --}}
            <article class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition">
                <div class="text-5xl mb-4">🛍️</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Kelola Pesanan</h3>
                <p class="text-gray-600 mb-4 text-sm">Monitor semua transaksi pesanan</p>
                <a href="{{ route('admin.pesanan.index') }}" class="inline-block px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-semibold">
                    Lihat Pesanan
                </a>
            </article>

            {{-- Kelola Kategori --}}
            <article class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition">
                <div class="text-5xl mb-4">🏷️</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Kelola Kategori</h3>
                <p class="text-gray-600 mb-4 text-sm">Tambah dan edit kategori produk</p>
                <a href="#" class="inline-block px-6 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition text-sm font-semibold">
                    Lihat Kategori
                </a>
            </article>

            {{-- Laporan --}}
            <article class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition">
                <div class="text-5xl mb-4">📊</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Laporan & Statistik</h3>
                <p class="text-gray-600 mb-4 text-sm">Lihat laporan penjualan dan statistik</p>
                <a href="#" class="inline-block px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-semibold">
                    Lihat Laporan
                </a>
            </article>

            {{-- Pengaturan --}}
            <article class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition">
                <div class="text-5xl mb-4">⚙️</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Pengaturan Sistem</h3>
                <p class="text-gray-600 mb-4 text-sm">Konfigurasi dan setting platform</p>
                <a href="#" class="inline-block px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm font-semibold">
                    Pengaturan
                </a>
            </article>
        </div>
    </section>

    {{-- Recent Activity --}}
    <section class="bg-white rounded-xl shadow-lg p-8" aria-label="Aktivitas Terbaru">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Aktivitas Terbaru</h2>
        <div class="text-center py-12">
            <p class="text-gray-500">Belum ada aktivitas terbaru</p>
        </div>
    </section>
@endsection
