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
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->bigIncrements('detail_id');
            $table->unsignedBigInteger('pesanan_id')->index('detail_pesanan_pesanan_id_foreign');
            $table->unsignedBigInteger('produk_id')->index('detail_pesanan_produk_id_foreign');
            $table->integer('jumlah');
            $table->double('harga_satuan');
            $table->double('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};
