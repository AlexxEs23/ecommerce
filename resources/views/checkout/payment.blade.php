<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - QRIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
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
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center gap-2">
                    <span class="text-3xl">🛒</span>
                    <h1 class="text-2xl font-bold text-purple-700">UMKM Market</h1>
                </div>
                
                <div class="flex items-center gap-4">
                    @auth
                        <div class="relative group">
                            <button class="flex items-center gap-2 px-4 py-2 bg-purple-100 rounded-lg hover:bg-purple-200 transition">
                                <span class="text-2xl">👤</span>
                                <div class="text-left">
                                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-600">{{ ucfirst(Auth::user()->role) }}</p>
                                </div>
                                <span class="text-gray-500">▼</span>
                            </button>
                            
                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <div class="py-2">
                                    <a href="{{ route('pembeli.dashboard') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-purple-50 transition">
                                        <span class="text-xl">📊</span>
                                        <span class="text-gray-700">Dashboard</span>
                                    </a>
                                    <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-purple-50 transition">
                                        <span class="text-xl">👤</span>
                                        <span class="text-gray-700">Profil Saya</span>
                                    </a>
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
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Payment Container -->
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <nav class="flex items-center gap-2 text-sm text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-purple-600 transition">🏠 Beranda</a>
                <span>›</span>
                <a href="{{ route('checkout.show', $pesanan->produk_id) }}" class="hover:text-purple-600 transition">Checkout</a>
                <span>›</span>
                <span class="text-purple-600 font-semibold">Pembayaran</span>
            </nav>
        </div>

        <!-- Page Title -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">💳 Pembayaran</h1>
            <p class="text-gray-600">Silakan lakukan pembayaran untuk menyelesaikan pesanan Anda</p>
        </div>

        <!-- Payment Card -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <!-- Order Summary -->
            <div class="mb-6 pb-6 border-b">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span>📦</span> Detail Pesanan
                </h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Produk</span>
                        <span class="font-semibold text-gray-800">{{ $pesanan->produk->nama_produk }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumlah</span>
                        <span class="font-semibold text-gray-800">{{ $pesanan->jumlah }} unit</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Penerima</span>
                        <span class="font-semibold text-gray-800">{{ $pesanan->nama_penerima }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="text-gray-600">Alamat</span>
                        <span class="font-semibold text-gray-800 text-right max-w-xs">{{ $pesanan->alamat }}</span>
                    </div>
                    <div class="flex justify-between pt-3 border-t">
                        <span class="text-lg font-bold text-gray-800">Total Pembayaran</span>
                        <span class="text-2xl font-bold text-purple-600">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Button -->
            <div class="text-center">
                <button id="pay-button" class="w-full md:w-auto px-8 py-4 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:shadow-lg transition text-lg">
                    <span class="flex items-center justify-center gap-2">
                        <span>📱</span>
                        <span>Bayar Sekarang</span>
                    </span>
                </button>
                
                <p class="mt-4 text-sm text-gray-600">
                    Anda akan diarahkan ke halaman pembayaran Midtrans
                </p>
                
                <div class="mt-6 flex items-center justify-center gap-2 text-sm text-gray-500">
                    <span>🔒</span>
                    <span>Pembayaran aman dan terenkripsi</span>
                </div>
            </div>

            <!-- Payment Methods Info -->
            <div class="mt-8 p-4 bg-purple-50 rounded-lg">
                <h3 class="font-semibold text-gray-800 mb-3 text-center">Metode Pembayaran yang Tersedia:</h3>
                <div class="flex items-center justify-center gap-4 flex-wrap">
                    <div class="px-3 py-2 bg-white rounded-lg shadow-sm">
                        <span class="text-sm font-semibold">📱 QRIS</span>
                    </div>
                    <div class="px-3 py-2 bg-white rounded-lg shadow-sm">
                        <span class="text-sm font-semibold">💚 GoPay</span>
                    </div>
                    <div class="px-3 py-2 bg-white rounded-lg shadow-sm">
                        <span class="text-sm font-semibold">🧡 ShopeePay</span>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-6 text-center">
                <a href="{{ route('pembeli.dashboard') }}" class="text-purple-600 hover:text-purple-800 transition text-sm font-semibold">
                    ← Kembali ke Dashboard
                </a>
            </div>
        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
            <div class="flex items-start gap-2">
                <span class="text-xl">ℹ️</span>
                <div class="text-sm text-gray-700">
                    <p class="font-semibold mb-1">Informasi Pembayaran</p>
                    <ul class="list-disc list-inside space-y-1 text-gray-600">
                        <li>Pembayaran akan segera dikonfirmasi secara otomatis</li>
                        <li>Pesanan akan diproses setelah pembayaran berhasil</li>
                        <li>Jika ada kendala, hubungi customer service kami</li>
                    </ul>
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

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            // Disable button to prevent double clicks
            payButton.disabled = true;
            payButton.innerHTML = '<span class="flex items-center justify-center gap-2"><span>⏳</span><span>Memproses...</span></span>';
            
            // Trigger snap popup
            window.snap.pay('{{ $pesanan->snap_token }}', {
                onSuccess: function(result) {
                    console.log('Payment success:', result);
                    // Send callback to server
                    window.location.href = '{{ route("checkout.payment.callback", $pesanan->id) }}?status=success';
                },
                onPending: function(result) {
                    console.log('Payment pending:', result);
                    // Send callback to server
                    window.location.href = '{{ route("checkout.payment.callback", $pesanan->id) }}?status=success';
                },
                onError: function(result) {
                    console.log('Payment error:', result);
                    alert('Pembayaran gagal! Silakan coba lagi.');
                    payButton.disabled = false;
                    payButton.innerHTML = '<span class="flex items-center justify-center gap-2"><span>📱</span><span>Bayar Sekarang</span></span>';
                },
                onClose: function() {
                    console.log('Payment popup closed');
                    // Delete pending order when user closes popup
                    if (confirm('Apakah Anda yakin ingin membatalkan pembayaran?')) {
                        window.location.href = '{{ route("checkout.payment.callback", $pesanan->id) }}?status=cancelled';
                    } else {
                        payButton.disabled = false;
                        payButton.innerHTML = '<span class="flex items-center justify-center gap-2"><span>📱</span><span>Bayar Sekarang</span></span>';
                    }
                }
            });
        });
    </script>
</body>
</html>
