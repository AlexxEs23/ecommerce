<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed categories first
        $this->call([
            KategoriSeeder::class,
        ]);

        // Create test users
        // Admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@umkm.com',
            'role' => 'admin',
        ]);

        // Penjual user
        User::factory()->create([
            'name' => 'Penjual User',
            'email' => 'penjual@umkm.com',
            'role' => 'penjual',
        ]);

        // Pembeli user
        User::factory()->create([
            'name' => 'Pembeli User',
            'email' => 'pembeli@umkm.com',
            'role' => 'pembeli',
        ]);
    }
}
