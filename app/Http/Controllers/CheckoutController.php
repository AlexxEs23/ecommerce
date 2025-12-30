<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    /**
     * Display the checkout form for a specific product
     */
    public function show($id)
    {
        $produk = Produk::with('kategori', 'user')->findOrFail($id);
        
        // Check if product is available
        if ($produk->stok <= 0) {
            return redirect()->back()->with('error', 'Produk tidak tersedia atau stok habis.');
        }
        
        if (!$produk->status) {
            return redirect()->back()->with('error', 'Produk sedang tidak aktif.');
        }
        
        return view('checkout.formCheckout', compact('produk'));
    }
    
    /**
     * Process the checkout
     */
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1',
            'nama_penerima' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'ekspedisi' => 'required|string|in:jne,jnt,sicepat,anteraja,ninja',
            'metode_pembayaran' => 'required|string|in:transfer_bank,cod,qris',
            'catatan_pembeli' => 'nullable|string|max:500',
        ]);
        
        $produk = Produk::findOrFail($request->produk_id);
        
        // Check stock availability
        if ($produk->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }
        
        // Calculate total
        $total = $produk->harga * $request->jumlah;
        
        // Determine status based on payment method:
        // - QRIS: 'pending_payment' (waiting for payment via webhook)
        // - Transfer Bank: 'dibayar' (waiting for manual payment confirmation)
        // - COD: 'diproses' (payment on delivery, can be processed immediately)
        if ($request->metode_pembayaran === 'qris') {
            $status = 'pending_payment';
        } elseif ($request->metode_pembayaran === 'transfer_bank') {
            $status = 'dibayar';
        } else { // COD
            $status = 'diproses';
        }
        
        // Create order
        $pesanan = Pesanan::create([
            'user_id' => Auth::id(),
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'total' => $total,
            'status' => $status,
            'nama_penerima' => $request->nama_penerima,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'ekspedisi' => $request->ekspedisi,
            'metode_pembayaran' => $request->metode_pembayaran,
            'catatan_pembeli' => $request->catatan_pembeli,
            'ongkir' => 0, // Set to 0 for now, can be calculated later
        ]);
        
        // Reduce stock for Transfer Bank and COD (not for QRIS - will be reduced after payment)
        if ($request->metode_pembayaran !== 'qris') {
            $produk->decrement('stok', $request->jumlah);
        }
        
        // If payment method is QRIS, create Midtrans Snap Token
        if ($request->metode_pembayaran === 'qris') {
            // Configure Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');
            
            // Prepare transaction parameters
            $params = [
                'transaction_details' => [
                    'order_id' => 'ORDER-' . $pesanan->id . '-' . time(),
                    'gross_amount' => (int) $total,
                ],
                'customer_details' => [
                    'first_name' => $request->nama_penerima,
                    'phone' => $request->no_hp,
                    'shipping_address' => [
                        'address' => $request->alamat,
                    ],
                ],
                'item_details' => [
                    [
                        'id' => $produk->id,
                        'price' => (int) $produk->harga,
                        'quantity' => $request->jumlah,
                        'name' => $produk->nama_produk,
                    ],
                ],
                'enabled_payments' => ['qris', 'gopay', 'shopeepay'],
            ];
            
            try {
                // Get Snap Token
                $snapToken = Snap::getSnapToken($params);
                $pesanan->update(['snap_token' => $snapToken]);
                
                return redirect()->route('checkout.payment', $pesanan->id);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal membuat transaksi pembayaran: ' . $e->getMessage());
            }
        }
        
        return redirect()->route('checkout.success', $pesanan->id)->with('success', 'Pesanan berhasil dibuat!');
    }
    
    /**
     * Show success page after checkout
     */
    public function success($id)
    {
        $pesanan = Pesanan::with('produk', 'user')->where('user_id', Auth::id())->findOrFail($id);
        
        return view('checkout.success', compact('pesanan'));
    }
    
    /**
     * Show payment page for QRIS
     */
    public function payment($id)
    {
        $pesanan = Pesanan::with('produk', 'user')->where('user_id', Auth::id())->findOrFail($id);
        
        if (!$pesanan->snap_token) {
            return redirect()->route('checkout.success', $pesanan->id)->with('error', 'Token pembayaran tidak ditemukan.');
        }
        
        return view('checkout.payment', compact('pesanan'));
    }
    
    /**
     * Handle payment callback from Midtrans (from frontend)
     */
    public function paymentCallback(Request $request, $id)
    {
        $pesanan = Pesanan::with('produk')->where('user_id', Auth::id())->findOrFail($id);
        
        // Check if payment was successful
        if ($request->status === 'success') {
            // Note: Actual status update will be handled by webhook
            // This is just for user feedback
            return redirect()->route('pembeli.pesanan')->with('success', 'Pembayaran sedang diproses. Silakan tunggu konfirmasi.');
        } else {
            // Payment was cancelled - delete the pending order
            if ($pesanan->status === 'pending_payment') {
                $pesanan->delete();
            }
            
            return redirect()->route('home')->with('error', 'Pembayaran dibatalkan. Silakan coba lagi.');
        }
    }
    
    /**
     * User confirms order received (change status from 'dikirim' to 'selesai')
     */
    public function confirmReceived($id)
    {
        $pesanan = Pesanan::where('user_id', Auth::id())->findOrFail($id);
        
        // Only allow confirmation for 'dikirim' status
        if ($pesanan->status !== 'dikirim') {
            return redirect()->back()->with('error', 'Hanya pesanan dengan status "Dikirim" yang dapat dikonfirmasi.');
        }
        
        // Update status to 'selesai'
        $pesanan->update(['status' => 'selesai']);
        
        return redirect()->back()->with('success', 'Terima kasih! Pesanan telah dikonfirmasi diterima.');
    }
    
    /**
     * Regenerate Snap token for pending payment
     */
    public function regenerateToken($id)
    {
        $pesanan = Pesanan::with('produk')->where('user_id', Auth::id())->findOrFail($id);
        
        // Only regenerate for pending payments
        if ($pesanan->status !== 'pending_payment') {
            return redirect()->route('pembeli.pesanan')->with('error', 'Pesanan ini tidak dalam status pending payment.');
        }
        
        try {
            // Configure Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');
            
            // Prepare transaction parameters
            $params = [
                'transaction_details' => [
                    'order_id' => 'ORDER-' . $pesanan->id . '-' . time(),
                    'gross_amount' => (int) $pesanan->total,
                ],
                'customer_details' => [
                    'first_name' => $pesanan->nama_penerima,
                    'phone' => $pesanan->no_hp,
                    'shipping_address' => [
                        'address' => $pesanan->alamat,
                    ],
                ],
                'item_details' => [
                    [
                        'id' => $pesanan->produk->id,
                        'price' => (int) ($pesanan->total / $pesanan->jumlah),
                        'quantity' => $pesanan->jumlah,
                        'name' => $pesanan->produk->nama_produk,
                    ],
                ],
                'enabled_payments' => ['qris', 'gopay', 'shopeepay'],
            ];
            
            // Get new Snap Token
            $snapToken = Snap::getSnapToken($params);
            $pesanan->update(['snap_token' => $snapToken]);
            
            return redirect()->route('checkout.payment', $pesanan->id);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat transaksi pembayaran: ' . $e->getMessage());
        }
    }
    
    // ==================== ADMIN METHODS ====================
    
    /**
     * Admin: Display all orders with status 'menunggu'
     */
    public function adminIndex()
    {
        $pesanan = Pesanan::with(['user', 'produk.user'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.pesanan.index', compact('pesanan'));
    }
    
    /**
     * Admin: Change order status to 'diproses'
     */
    public function adminProses($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        
        if (!in_array($pesanan->status, ['dibayar', 'menunggu'])) {
            return redirect()->back()->with('error', 'Pesanan tidak dapat diproses. Status saat ini: ' . $pesanan->status);
        }
        
        $pesanan->update(['status' => 'diproses']);
        
        return redirect()->back()->with('success', 'Pesanan berhasil diproses!');
    }
    
    /**
     * Admin: Change order status to 'selesai'
     */
    public function adminSelesai($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        
        if ($pesanan->status !== 'dikirim') {
            return redirect()->back()->with('error', 'Hanya pesanan dengan status "dikirim" yang dapat diselesaikan.');
        }
        
        $pesanan->update(['status' => 'selesai']);
        
        return redirect()->back()->with('success', 'Pesanan berhasil diselesaikan!');
    }
    
    /**
     * Admin: Cancel order
     */
    public function adminBatal($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        
        if (in_array($pesanan->status, ['selesai', 'dibatalkan'])) {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan.');
        }
        
        // Return stock if order was already paid (stock was reduced)
        if (in_array($pesanan->status, ['dibayar', 'diproses'])) {
            $produk = Produk::find($pesanan->produk_id);
            if ($produk) {
                $produk->increment('stok', $pesanan->jumlah);
            }
        }
        
        $pesanan->update(['status' => 'dibatalkan']);
        
        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan dan stok dikembalikan!');
    }
    
    // ==================== PENJUAL METHODS ====================
    
    /**
     * Penjual: Display orders for products owned by this seller
     */
    public function penjualIndex()
    {
        $pesanan = Pesanan::with(['user', 'produk'])
            ->whereHas('produk', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('penjual.pesanan.index', compact('pesanan'));
    }
    
    /**
     * Penjual: Show form to input resi
     */
    public function penjualResiForm($id)
    {
        $pesanan = Pesanan::with('produk')
            ->whereHas('produk', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($id);
        
        if ($pesanan->status !== 'diproses') {
            return redirect()->back()->with('error', 'Hanya pesanan dengan status "diproses" yang dapat dikirim.');
        }
        
        return view('penjual.pesanan.resi', compact('pesanan'));
    }
    
    /**
     * Penjual: Input resi and change status to 'dikirim'
     */
    public function penjualKirim(Request $request, $id)
    {
        $request->validate([
            'resi' => 'required|string|max:255',
        ]);
        
        $pesanan = Pesanan::with('produk')
            ->whereHas('produk', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($id);
        
        if ($pesanan->status !== 'diproses') {
            return redirect()->back()->with('error', 'Hanya pesanan dengan status "diproses" yang dapat dikirim.');
        }
        
        $pesanan->update([
            'resi' => $request->resi,
            'status' => 'dikirim'
        ]);
        
        return redirect()->route('penjual.pesanan.index')->with('success', 'Pesanan berhasil dikirim dengan resi: ' . $request->resi);
    }
}
