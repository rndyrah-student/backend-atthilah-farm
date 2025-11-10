<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformasiPeternakanTable extends Migration
{
    public function up()
    {
        Schema::create('informasi_peternakan', function (Blueprint $table) {
            $table->id('info_id');
            $table->string('nama_peternakan');
            $table->text('deskripsi')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('lokasi_maps')->nullable();
            $table->string('foto_peternakan')->nullable();
            $table->string('jam_operasional')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('informasi_peternakan');
    }
}