<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'pesanan_id';
    protected $fillable = [
        'pelanggan_id',
        'nama_pelanggan',
        'email_pelanggan',
        'no_telepon_pelanggan',
        'alamat_pengiriman',
        'tanggal_pesanan',
        'total_harga',
        'status',
        'catatan'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    public function detail_pesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    public function faktur()
    {
        return $this->hasOne(Faktur::class, 'pesanan_id');
    }

    protected function totalHarga(): Attribute
    {
    return Attribute::make(
        get: fn () => $this->detail_pesanan->sum(fn ($detail) => $detail->jumlah * $detail->harga_satuan));
    }
}