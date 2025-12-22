<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil produk untuk flash sale (misalnya produk dengan diskon)
        $flashSaleProducts = Produk::with(['kategori', 'user'])
            ->where('status', true)
            ->latest()
            ->take(6)
            ->get();
        
        // Ambil produk rekomendasi
        $recommendedProducts = Produk::with(['kategori', 'user'])
            ->where('status', true)
            ->inRandomOrder()
            ->take(10)
            ->get();
        
        // Ambil semua kategori
        $categories = Kategori::all();
        
        return view('index', compact('flashSaleProducts', 'recommendedProducts', 'categories'));
    }
}
