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
        Schema::create('produk', function (Blueprint $table) {
            $table->bigIncrements('produk_id');
            $table->unsignedBigInteger('kategori_id')->index('produk_kategori_id_foreign');
            $table->string('nama_produk');
            $table->double('berat')->nullable();
            $table->double('harga')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('foto_url')->nullable();
            $table->integer('stok')->default(0);
            $table->unsignedBigInteger('created_by')->index('produk_created_by_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
