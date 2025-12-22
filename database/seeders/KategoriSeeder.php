<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'Fashion', 'deskripsi' => 'Pakaian, aksesoris, dan fashion items'],
            ['nama_kategori' => 'Makanan', 'deskripsi' => 'Makanan dan minuman'],
            ['nama_kategori' => 'Kerajinan', 'deskripsi' => 'Kerajinan tangan dan seni'],
            ['nama_kategori' => 'Kecantikan', 'deskripsi' => 'Produk kecantikan dan perawatan'],
            ['nama_kategori' => 'Buku', 'deskripsi' => 'Buku dan publikasi'],
            ['nama_kategori' => 'Elektronik', 'deskripsi' => 'Perangkat elektronik dan gadget'],
            ['nama_kategori' => 'Rumah Tangga', 'deskripsi' => 'Perlengkapan rumah tangga'],
            ['nama_kategori' => 'Olahraga', 'deskripsi' => 'Perlengkapan olahraga dan fitness'],
        ];

        foreach ($categories as $category) {
            Kategori::create($category);
        }
    }
}
