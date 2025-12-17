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
        Schema::create('carts', function (Blueprint $table) {
            $table->id(); // id keranjang
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('produk_id');
            $table->integer('jumlah')->default(1);
            $table->timestamps();

            // Foreign key ke users.id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Foreign key ke produk.produk_id (BUKAN 'id'!)
            $table->foreign('produk_id')->references('produk_id')->on('produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
