<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'metode_pembayaran' => 'required|string|in:transfer_bank,cod',
            'catatan_pembeli' => 'nullable|string|max:500',
        ]);
        
        $produk = Produk::findOrFail($request->produk_id);
        
        // Check stock availability
        if ($produk->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }
        
        // Calculate total
        $total = $produk->harga * $request->jumlah;
        
        // Create order with status 'menunggu'
        $pesanan = Pesanan::create([
            'user_id' => Auth::id(),
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'total' => $total,
            'status' => 'menunggu',
            'nama_penerima' => $request->nama_penerima,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'ekspedisi' => $request->ekspedisi,
            'metode_pembayaran' => $request->metode_pembayaran,
            'catatan_pembeli' => $request->catatan_pembeli,
            'ongkir' => 0, // Set to 0 for now, can be calculated later
        ]);
        
        // Update stock
        $produk->decrement('stok', $request->jumlah);
        
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
        
        if ($pesanan->status !== 'menunggu') {
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
        
        // Return stock
        $produk = Produk::find($pesanan->produk_id);
        if ($produk) {
            $produk->increment('stok', $pesanan->jumlah);
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
