<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'Fashion', 'icon' => '👕'],
            ['nama_kategori' => 'Makanan', 'icon' => '🍽️'],
            ['nama_kategori' => 'Kerajinan', 'icon' => '🎨'],
            ['nama_kategori' => 'Kecantikan', 'icon' => '💄'],
            ['nama_kategori' => 'Buku', 'icon' => '📚'],
            ['nama_kategori' => 'Elektronik', 'icon' => '⚡'],
            ['nama_kategori' => 'Rumah Tangga', 'icon' => '🏠'],
            ['nama_kategori' => 'Olahraga', 'icon' => '⚽'],
            ['nama_kategori' => 'Hobi', 'icon' => '🎮'],
            ['nama_kategori' => 'Otomotif', 'icon' => '🚗'],
        ];

        foreach ($categories as $category) {
            Kategori::create($category);
        }
    }
}
