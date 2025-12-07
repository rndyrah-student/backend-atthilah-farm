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
        $admin = User::firstOrCreate(
            ['email' => 'admin1@example.com'],
            [
                'username' => 'admin1',
                'password' => bcrypt('password123'),
                'nama_lengkap' => 'Admin Satu',
                'no_telepon' => '081234567891',
                'alamat' => 'Jebres',
                'role' => 'Admin'
            ]
        );

        User::firstOrCreate(
            ['email' => 'cust1@example.com'],
            [
                'username' => 'cust1',
                'password' => bcrypt('password123'),
                'nama_lengkap' => 'Customer Satu',
                'no_telepon' => '081234567891',
                'alamat' => 'Jebres',
                'role' => 'Pelanggan'
            ]
        );


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
            'foto_url' => '',
            'stok' => 50,
            'created_by' => $admin->id,
        ]);
        Produk::create([
            'kategori_id' => $kategoriSapi->kategori_id,
            'nama_produk' => 'Daging Sapi Premium',
            'berat' => 2.0,
            'harga' => 150000,
            'deskripsi' => 'Daging sapi premium, empuk dan lezat',
            'foto_url' => '',
            'stok' => 30,
            'created_by' => $admin->id,
        ]);
        Produk::create([
            'kategori_id' => $kategoriKambing->kategori_id,
            'nama_produk' => 'Kambing Guling Siap Saji',
            'berat' => 3.0,
            'harga' => 250000,
            'deskripsi' => 'Kambing guling siap saji untuk acara spesial',
            'foto_url' => '',
            'stok' => 20,
            'created_by' => $admin->id,
        ]);
    }
}