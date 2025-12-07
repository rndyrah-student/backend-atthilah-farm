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
        Schema::create('faktur', function (Blueprint $table) {
            $table->bigIncrements('faktur_id');
            $table->unsignedBigInteger('pesanan_id')->index('faktur_pesanan_id_foreign');
            $table->string('nomor_faktur')->unique();
            $table->dateTime('tanggal_faktur')->default('2025-11-12 19:09:10');
            $table->double('total_pembayaran');
            $table->string('metode_pembayaran')->nullable();
            $table->enum('status_pembayaran', ['Belum Dibayar', 'Sudah Dibayar', 'Gagal'])->default('Belum Dibayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faktur');
    }
};
