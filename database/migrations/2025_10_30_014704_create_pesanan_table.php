<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesananTable extends Migration
{
    public function up()
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('pesanan_id');
            $table->foreignId('pelanggan_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->string('nama_pelanggan');
            $table->string('email_pelanggan');
            $table->string('no_telepon_pelanggan');
            $table->text('alamat_pengiriman');
            $table->dateTime('tanggal_pesanan')->default(now());
            $table->float('total_harga');
            $table->enum('status', ['Menunggu Konfirmasi', 'Dikonfirmasi', 'Ditolak', 'Selesai'])->default('Menunggu Konfirmasi');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesanan');
    }
}