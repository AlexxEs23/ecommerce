<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - {{ $produk->nama_produk }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

    <!-- Checkout Container -->
    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <nav class="flex items-center gap-2 text-sm text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-purple-600 transition">🏠 Beranda</a>
                <span>›</span>
                <span class="text-purple-600 font-semibold">Checkout</span>
            </nav>
        </div>

        <!-- Page Title -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">🛒 Checkout Produk</h1>
            <p class="text-gray-600">Lengkapi informasi berikut untuk menyelesaikan pesanan Anda</p>
        </div>

        @if(session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                <div class="flex items-center gap-2">
                    <span class="text-xl">⚠️</span>
                    <p class="font-semibold">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                <div class="flex items-start gap-2">
                    <span class="text-xl">⚠️</span>
                    <div>
                        <p class="font-semibold mb-2">Terdapat kesalahan:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Checkout -->
            <div class="lg:col-span-2">
                <form action="{{ route('checkout.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">

                    <!-- Product Info Card -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span>📦</span> Detail Produk
                        </h2>
                        
                        <div class="flex gap-4">
                            <div class="w-24 h-24 rounded-lg overflow-hidden bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center flex-shrink-0">
                                @if($produk->gambar)
                                    <img src="{{ asset('storage/' . $produk->gambar) }}" 
                                         alt="{{ $produk->nama_produk }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <span class="text-4xl">📦</span>
                                @endif
                            </div>
                            
                            <div class="flex-1">
                                <h3 class="font-bold text-lg text-gray-800 mb-2">{{ $produk->nama_produk }}</h3>
                                <p class="text-sm text-gray-600 mb-2">{{ Str::limit($produk->deskripsi, 100) }}</p>
                                <div class="flex items-center gap-4 text-sm">
                                    <span class="text-purple-600 font-semibold">📂 {{ $produk->kategori->nama_kategori ?? 'Umum' }}</span>
                                    <span class="text-gray-600">📦 Stok: {{ $produk->stok }}</span>
                                </div>
                                <div class="mt-2">
                                    <span class="text-2xl font-bold text-purple-600">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                                    <span class="text-sm text-gray-500">/ unit</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quantity Selection -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span>🔢</span> Jumlah Pembelian
                        </h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Produk</label>
                                <div class="flex items-center gap-4">
                                    <button type="button" onclick="decreaseQty()" class="w-10 h-10 bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition font-bold">-</button>
                                    <input type="number" 
                                           id="jumlah" 
                                           name="jumlah" 
                                           value="1" 
                                           min="1" 
                                           max="{{ $produk->stok }}" 
                                           class="w-24 text-center px-4 py-2 border-2 border-purple-600 rounded-lg focus:outline-none focus:border-purple-700 font-semibold text-lg"
                                           onchange="updateTotal()">
                                    <button type="button" onclick="increaseQty()" class="w-10 h-10 bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition font-bold">+</button>
                                    <span class="text-sm text-gray-600">Maksimal: {{ $produk->stok }} unit</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span>📍</span> Informasi Pengiriman
                        </h2>
                        
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="nama_penerima" class="block text-sm font-semibold text-gray-700 mb-2">Nama Penerima</label>
                                    <input type="text" 
                                           id="nama_penerima" 
                                           name="nama_penerima" 
                                           required
                                           value="{{ old('nama_penerima', Auth::user()->name) }}"
                                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-600 transition"
                                           placeholder="Nama lengkap penerima">
                                </div>
                                <div>
                                    <label for="no_hp" class="block text-sm font-semibold text-gray-700 mb-2">Nomor HP</label>
                                    <input type="text" 
                                           id="no_hp" 
                                           name="no_hp" 
                                           required
                                           value="{{ old('no_hp') }}"
                                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-600 transition"
                                           placeholder="08xxxxxxxxxx">
                                </div>
                            </div>
                            
                            <div>
                                <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                                <textarea id="alamat" 
                                          name="alamat" 
                                          rows="4" 
                                          required
                                          class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-600 transition"
                                          placeholder="Masukkan alamat lengkap pengiriman (Nama Jalan, RT/RW, Kelurahan, Kecamatan, Kota, Provinsi, Kode Pos)">{{ old('alamat') }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">💡 Pastikan alamat lengkap dan benar untuk memudahkan pengiriman</p>
                            </div>
                            
                            <div>
                                <label for="ekspedisi" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Ekspedisi</label>
                                <select id="ekspedisi" 
                                        name="ekspedisi" 
                                        required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-600 transition">
                                    <option value="">Pilih ekspedisi pengiriman</option>
                                    <option value="jne" {{ old('ekspedisi') == 'jne' ? 'selected' : '' }}>JNE - Jalur Nugraha Ekakurir</option>
                                    <option value="jnt" {{ old('ekspedisi') == 'jnt' ? 'selected' : '' }}>J&T Express</option>
                                    <option value="sicepat" {{ old('ekspedisi') == 'sicepat' ? 'selected' : '' }}>SiCepat</option>
                                    <option value="anteraja" {{ old('ekspedisi') == 'anteraja' ? 'selected' : '' }}>AnterAja</option>
                                    <option value="ninja" {{ old('ekspedisi') == 'ninja' ? 'selected' : '' }}>Ninja Express</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span>💳</span> Metode Pembayaran
                        </h2>
                        
                        <div class="space-y-3">
                            <label class="flex items-start gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-600 transition">
                                <input type="radio" name="metode_pembayaran" value="transfer_bank" required class="mt-1" checked>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-xl">🏦</span>
                                        <span class="font-semibold text-gray-800">Transfer Bank</span>
                                    </div>
                                    <p class="text-sm text-gray-600">Transfer melalui rekening bank BCA, BNI, Mandiri, atau BRI</p>
                                </div>
                            </label>

                            <label class="flex items-start gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-600 transition">
                                <input type="radio" name="metode_pembayaran" value="cod" required class="mt-1">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-xl">💵</span>
                                        <span class="font-semibold text-gray-800">Cash on Delivery (COD)</span>
                                    </div>
                                    <p class="text-sm text-gray-600">Bayar langsung saat barang diterima</p>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Catatan Pembeli -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span>📝</span> Catatan untuk Penjual (Opsional)
                        </h2>
                        
                        <div>
                            <textarea id="catatan_pembeli" 
                                      name="catatan_pembeli" 
                                      rows="3" 
                                      class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-600 transition"
                                      placeholder="Tambahkan catatan khusus untuk pesanan Anda (opsional)">{{ old('catatan_pembeli') }}</textarea>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4">
                        <a href="{{ route('home') }}" class="flex-1 px-6 py-3 border-2 border-purple-600 text-purple-600 rounded-lg font-semibold hover:bg-purple-50 transition text-center">
                            ← Kembali Belanja
                        </a>
                        <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:shadow-lg transition">
                            Buat Pesanan →
                        </button>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <span>📋</span> Ringkasan Pesanan
                    </h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Harga Satuan</span>
                            <span class="font-semibold" id="price-per-unit">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex justify-between text-gray-600">
                            <span>Jumlah</span>
                            <span class="font-semibold" id="qty-display">1 unit</span>
                        </div>
                        
                        <div class="border-t pt-4">
                            <div class="flex justify-between text-gray-600 mb-2">
                                <span>Subtotal</span>
                                <span class="font-semibold" id="subtotal">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="flex justify-between text-gray-600 mb-2">
                                <span>Biaya Admin</span>
                                <span class="font-semibold">Rp 0</span>
                            </div>
                            
                            <div class="flex justify-between text-gray-600">
                                <span>Ongkos Kirim</span>
                                <span class="font-semibold text-green-600">GRATIS</span>
                            </div>
                        </div>
                        
                        <div class="border-t pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-800">Total Pembayaran</span>
                                <div class="text-right">
                                    <span class="text-2xl font-bold text-purple-600" id="total">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="bg-purple-50 border-l-4 border-purple-600 p-4 rounded-lg">
                        <div class="flex items-start gap-2">
                            <span class="text-xl">ℹ️</span>
                            <div class="text-sm text-gray-700">
                                <p class="font-semibold mb-1">Info Penjual</p>
                                <p>{{ $produk->user->name ?? 'Toko UMKM' }}</p>
                                <p class="text-xs text-gray-600 mt-2">✓ Penjual Terverifikasi</p>
                            </div>
                        </div>
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

    <script>
        const pricePerUnit = {{ $produk->harga }};
        const maxStock = {{ $produk->stok }};

        function updateTotal() {
            const qty = parseInt(document.getElementById('jumlah').value) || 1;
            const total = pricePerUnit * qty;
            
            document.getElementById('qty-display').textContent = qty + ' unit';
            document.getElementById('subtotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        function increaseQty() {
            const input = document.getElementById('jumlah');
            const currentValue = parseInt(input.value) || 1;
            
            if (currentValue < maxStock) {
                input.value = currentValue + 1;
                updateTotal();
            }
        }

        function decreaseQty() {
            const input = document.getElementById('jumlah');
            const currentValue = parseInt(input.value) || 1;
            
            if (currentValue > 1) {
                input.value = currentValue - 1;
                updateTotal();
            }
        }

        // Update total when quantity input changes
        document.getElementById('jumlah').addEventListener('input', function() {
            let value = parseInt(this.value) || 1;
            
            if (value < 1) {
                this.value = 1;
            } else if (value > maxStock) {
                this.value = maxStock;
            }
            
            updateTotal();
        });
    </script>
</body>
</html>
