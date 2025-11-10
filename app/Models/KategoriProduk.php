<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    use HasFactory;

    // 🔥 Tambahkan ini!
    protected $table = 'kategori_produk'; // sesuaikan dengan nama tabel di DB

    protected $primaryKey = 'kategori_id';

    public $timestamps = true;
}