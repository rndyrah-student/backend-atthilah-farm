<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukTable extends Migration
{
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('produk_id');
            $table->foreignId('kategori_id')->constrained('kategori_produk', 'kategori_id')->onDelete('cascade');
            $table->string('nama_produk');
            $table->float('berat')->nullable();
            $table->float('harga');
            $table->text('deskripsi')->nullable();
            $table->string('foto_url')->nullable();
            $table->integer('stok')->default(0);
            $table->foreignId('created_by')->constrained('users', 'user_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produk');
    }
}