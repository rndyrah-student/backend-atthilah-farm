<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriProduk;

class KategoriProdukSeeder extends Seeder
{
    public function run()
    {
        KategoriProduk::insert([
            ['nama_kategori' => 'Ayam', 'deskripsi' => 'Produk dari ayam'],
            ['nama_kategori' => 'Sapi', 'deskripsi' => 'Produk dari sapi'],
            ['nama_kategori' => 'Kambing', 'deskripsi' => 'Produk dari kambing'],
        ]);
    }
}