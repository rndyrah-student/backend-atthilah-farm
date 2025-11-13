<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faktur extends Model
{
    use HasFactory;

    protected $table = 'faktur';
    protected $primaryKey = 'faktur_id';
    protected $fillable = [
        'pesanan_id',
        'nomor_faktur',
        'tanggal_faktur',
        'total_pembayaran',
        'metode_pembayaran',
        'status_pembayaran'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }
}