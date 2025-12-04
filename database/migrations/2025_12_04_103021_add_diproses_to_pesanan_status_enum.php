<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("
            ALTER TABLE pesanan 
            MODIFY status ENUM(
                'Menunggu Konfirmasi',
                'Dikonfirmasi',
                'Ditolak',
                'Diproses',
                'Selesai'
            ) NOT NULL
        ");
    }

    public function down()
    {
        // Hapus 'Diproses' saat rollback
        DB::statement("
            ALTER TABLE pesanan 
            MODIFY status ENUM(
                'Menunggu Konfirmasi',
                'Dikonfirmasi',
                'Ditolak',
                'Selesai'
            ) NOT NULL
        ");
    }
};