<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFakturTable extends Migration
{
    public function up()
    {
        Schema::create('faktur', function (Blueprint $table) {
            $table->id('faktur_id');
            $table->foreignId('pesanan_id')->constrained('pesanan', 'pesanan_id')->onDelete('cascade');
            $table->string('nomor_faktur')->unique();
            $table->dateTime('tanggal_faktur')->default(now());
            $table->float('total_pembayaran');
            $table->string('metode_pembayaran')->nullable();
            $table->enum('status_pembayaran', ['Belum Dibayar', 'Sudah Dibayar', 'Gagal'])->default('Belum Dibayar');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('faktur');
    }
}