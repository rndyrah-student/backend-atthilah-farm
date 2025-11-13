<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiPeternakan extends Model
{
    use HasFactory;

    protected $table = 'informasi_peternakan';
    protected $primaryKey = 'info_id';
    protected $fillable = [
        'nama_peternakan',
        'deskripsi',
        'alamat',
        'no_telepon',
        'email',
        'lokasi_maps',
        'foto_peternakan',
        'jam_operasional'
    ];
}