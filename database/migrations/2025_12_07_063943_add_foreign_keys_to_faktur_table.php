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
        Schema::table('faktur', function (Blueprint $table) {
            $table->foreign(['pesanan_id'])->references(['pesanan_id'])->on('pesanan')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faktur', function (Blueprint $table) {
            $table->dropForeign('faktur_pesanan_id_foreign');
        });
    }
};
