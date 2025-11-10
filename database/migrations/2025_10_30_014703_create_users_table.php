<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('nama_lengkap')->nullable();
            $table->string('no_telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('role', ['Admin', 'Penjual', 'Pelanggan'])->default('Pelanggan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}