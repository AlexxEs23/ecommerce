<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - UMKM Market</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    
    <!-- Top Bar -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white text-sm py-2">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <span>📱 Download Aplikasi</span>
            </div>
        </div>
    </div>

    <!-- Main Navbar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="text-3xl">🛒</span>
                    <h1 class="text-2xl font-bold text-purple-700">UMKM Market</h1>
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-12">
        <!-- Success Icon & Message -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-6">
                <span class="text-6xl">✅</span>
            </div>
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Pesanan Berhasil Dibuat!</h1>
            <p class="text-lg text-gray-600">Terima kasih telah berbelanja di UMKM Market</p>
        </div>

        <!-- Order Details Card -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
            <div class="border-b pb-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Detail Pesanan</h2>
                <p class="text-gray-600">Nomor Pesanan: <span class="font-bold text-purple-600">#{{ $pesanan->id }}</span></p>
                <p class="text-sm text-gray-500">{{ $pesanan->created_at->format('d F Y, H:i') }} WIB</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Product Info -->
                <div>
                    <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <span>📦</span> Produk yang Dipesan
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="font-bold text-gray-800">{{ $pesanan->produk->nama_produk }}</p>
                        <p class="text-sm text-gray-600">Jumlah: {{ $pesanan->jumlah }} unit</p>
                        <p class="text-lg font-bold text-purple-600 mt-2">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Delivery Info -->
                <div>
                    <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <span>📍</span> Informasi Pengiriman
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="font-bold text-gray-800">{{ $pesanan->nama_penerima }}</p>
                        <p class="text-sm text-gray-600">{{ $pesanan->no_hp }}</p>
                        <p class="text-sm text-gray-600 mt-2">{{ $pesanan->alamat }}</p>
                        <p class="text-sm text-gray-600 mt-2">Ekspedisi: <span class="font-semibold uppercase">{{ $pesanan->ekspedisi }}</span></p>
                    </div>
                </div>

                <!-- Payment Info -->
                <div>
                    <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <span>💳</span> Metode Pembayaran
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="font-bold text-gray-800">
                            @if($pesanan->metode_pembayaran == 'transfer_bank')
                                🏦 Transfer Bank
                            @else
                                💵 Cash on Delivery (COD)
                            @endif
                        </p>
                        @if($pesanan->metode_pembayaran == 'transfer_bank')
                            <p class="text-sm text-gray-600 mt-2">Silakan lakukan pembayaran ke rekening penjual</p>
                        @else
                            <p class="text-sm text-gray-600 mt-2">Bayar saat barang diterima</p>
                        @endif
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <span>📊</span> Status Pesanan
                    </h3>
                    <div class="bg-yellow-50 rounded-lg p-4 border-2 border-yellow-200">
                        <p class="font-bold text-yellow-700 flex items-center gap-2">
                            <span>⏳</span> Menunggu Konfirmasi
                        </p>
                        <p class="text-sm text-yellow-600 mt-2">Pesanan Anda sedang menunggu konfirmasi dari penjual</p>
                    </div>
                </div>
            </div>

            @if($pesanan->catatan_pembeli)
                <div class="border-t pt-6">
                    <h3 class="font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <span>📝</span> Catatan Anda
                    </h3>
                    <p class="text-gray-600 italic bg-gray-50 rounded-lg p-4">{{ $pesanan->catatan_pembeli }}</p>
                </div>
            @endif
        </div>

        <!-- Payment Instructions (if transfer_bank) -->
        @if($pesanan->metode_pembayaran == 'transfer_bank')
            <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg mb-6">
                <h3 class="font-bold text-blue-800 mb-3 flex items-center gap-2">
                    <span>ℹ️</span> Instruksi Pembayaran
                </h3>
                <ol class="list-decimal list-inside space-y-2 text-blue-700">
                    <li>Penjual akan menghubungi Anda untuk konfirmasi dan informasi rekening</li>
                    <li>Lakukan transfer sesuai total pembayaran</li>
                    <li>Simpan bukti transfer Anda</li>
                    <li>Kirimkan bukti transfer kepada penjual</li>
                    <li>Pesanan akan diproses setelah pembayaran dikonfirmasi</li>
                </ol>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('home') }}" class="px-6 py-3 border-2 border-purple-600 text-purple-600 rounded-lg font-semibold hover:bg-purple-50 transition text-center">
                🏠 Kembali ke Beranda
            </a>
            <a href="{{ route('pembeli.dashboard') }}" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:shadow-lg transition text-center">
                📋 Lihat Pesanan Saya
            </a>
        </div>

        <!-- Next Steps -->
        <div class="mt-8 bg-purple-50 rounded-xl p-6">
            <h3 class="font-bold text-purple-800 mb-4 flex items-center gap-2">
                <span>🔔</span> Langkah Selanjutnya
            </h3>
            <div class="space-y-3">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-purple-200 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="font-bold text-purple-700">1</span>
                    </div>
                    <div>
                        <p class="font-semibold text-purple-900">Menunggu Konfirmasi</p>
                        <p class="text-sm text-purple-700">Admin dan penjual akan mengkonfirmasi pesanan Anda</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-purple-200 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="font-bold text-purple-700">2</span>
                    </div>
                    <div>
                        <p class="font-semibold text-purple-900">Pesanan Diproses</p>
                        <p class="text-sm text-purple-700">Penjual akan mempersiapkan produk Anda</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-purple-200 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="font-bold text-purple-700">3</span>
                    </div>
                    <div>
                        <p class="font-semibold text-purple-900">Pesanan Dikirim</p>
                        <p class="text-sm text-purple-700">Anda akan menerima nomor resi untuk tracking</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-purple-200 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="font-bold text-purple-700">4</span>
                    </div>
                    <div>
                        <p class="font-semibold text-purple-900">Pesanan Selesai</p>
                        <p class="text-sm text-purple-700">Barang sampai di tangan Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-400">© 2025 UMKM Market. Platform e-commerce untuk UMKM Indonesia.</p>
        </div>
    </footer>
</body>
</html>
