<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // ⚠️ Ganti nama tabel ke 'users'
    protected $table = 'users';

    // ⚠️ Ganti primary key ke 'id' (default Laravel)
    protected $primaryKey = 'id';

    protected $fillable = [
        'username',
        'password',
        'email',
        'nama_lengkap',
        'no_telepon',
        'alamat',
        'role',
        'created_by'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function products()
    {
        return $this->hasMany(Produk::class, 'created_by');
    }

    public function orders()
    {
        return $this->hasMany(Pesanan::class, 'pelanggan_id');
    }
}