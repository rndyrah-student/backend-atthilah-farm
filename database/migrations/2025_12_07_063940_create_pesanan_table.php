<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->bigIncrements('pesanan_id');
            $table->unsignedBigInteger('pelanggan_id')->index('pesanan_pelanggan_id_foreign');
            $table->string('nama_pelanggan');
            $table->string('email_pelanggan');
            $table->string('no_telepon_pelanggan');
            $table->text('alamat_pengiriman');
            $table->dateTime('tanggal_pesanan')->useCurrent();
            $table->enum('status', ['Menunggu Konfirmasi', 'Dikonfirmasi', 'Ditolak', 'Diproses', 'Selesai']);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
