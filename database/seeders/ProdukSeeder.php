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
        $penjual = User::firstOrCreate(
            ['email' => 'penjual1@example.com'], // cari berdasarkan email
            [
                'username' => 'penjual1',
                'password' => bcrypt('password'),
                'nama_lengkap' => 'Penjual Ayam',
                'no_telepon' => '081234567891',
                'alamat' => 'Jl. Penjual Ayam',
                'role' => 'Penjual'
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

        // 3. Buat produk — gunakan $penjual->id
        Produk::create([
            'kategori_id' => $kategoriAyam->kategori_id,
            'nama_produk' => 'Ayam Broiler Segar',
            'berat' => 1.5,
            'harga' => 35000,
            'deskripsi' => 'Ayam broiler segar, siap masak',
            'foto_url' => 'https://via.placeholder.com/300?text=Ayam+Broiler',
            'stok' => 50,
            'created_by' => $penjual->id, // ← INI YANG BENAR!
        ]);

        // ... (produk lainnya sama)
    }
}