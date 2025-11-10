<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'produk_id';

    protected $fillable = [
        'kategori_id',
        'nama_produk',
        'berat',
        'harga',
        'deskripsi',
        'foto_url',
        'stok',
        'created_by'
    ];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_id', 'kategori_id');
    }

    // Relasi ke User (yang membuat)
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }
}