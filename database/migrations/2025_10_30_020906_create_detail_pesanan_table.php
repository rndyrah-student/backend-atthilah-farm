<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPesananTable extends Migration
{
    public function up()
    {
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id('detail_id');
            $table->foreignId('pesanan_id')->constrained('pesanan', 'pesanan_id')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk', 'produk_id')->onDelete('cascade');
            $table->integer('jumlah');
            $table->float('harga_satuan');
            $table->float('subtotal');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_pesanan');
    }
}