<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil produk untuk flash sale (produk terbaru)
        $flashSaleProducts = Produk::with(['kategori', 'user'])
            ->where('status', true)
            ->latest()
            ->take(8)
            ->get();
        
        // Ambil semua produk untuk rekomendasi
        $recommendedProducts = Produk::with(['kategori', 'user'])
            ->where('status', true)
            ->latest()
            ->get();
        
        // Ambil semua kategori
        $categories = Kategori::all();
        
        return view('index', compact('flashSaleProducts', 'recommendedProducts', 'categories'));
    }
}
