<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriProduk;
use App\Models\User;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat user (gunakan id, bukan user_id)
        $admin = User::firstOrCreate(
            ['email' => 'admin1@example.com'], // cari berdasarkan email
            [
                'username' => 'admin1',
                'password' => bcrypt('password'),
                'nama_lengkap' => 'Penjual Ayam',
                'no_telepon' => '081234567891',
                'alamat' => 'Jl. Penjual Ayam',
                'role' => 'Admin'
            ]
        );

        // 2. Pastikan kategori ada
        $kategoriAyam = KategoriProduk::firstOrCreate(
            ['nama_kategori' => 'Ayam'],
            ['deskripsi' => 'Produk dari ayam']
        );

        $kategoriSapi = KategoriProduk::firstOrCreate(
            ['nama_kategori' => 'Sapi'],
            ['deskripsi' => 'Produk dari sapi']
        );

        $kategoriKambing = KategoriProduk::firstOrCreate(
            ['nama_kategori' => 'Kambing'],
            ['deskripsi' => 'Produk dari kambing']
        );

        // 3. Buat produk — gunakan $admin->id
        Produk::create([
            'kategori_id' => $kategoriAyam->kategori_id,
            'nama_produk' => 'Ayam Broiler Segar',
            'berat' => 1.5,
            'harga' => 35000,
            'deskripsi' => 'Ayam broiler segar, siap masak',
            'foto_url' => 'https://via.placeholder.com/300?text=Ayam+Broiler',
            'stok' => 50,
            'created_by' => $admin->id, // ← INI YANG BENAR!
        ]);

        // ... (produk lainnya sama)
    }
}