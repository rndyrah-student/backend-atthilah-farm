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
        Schema::create('informasi_peternakan', function (Blueprint $table) {
            $table->bigIncrements('info_id');
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_peternakan');
    }
};
