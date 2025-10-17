<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // 🔹 Tambah kolom teknisi (nullable dulu biar aman)
            $table->foreignId('technician_id')
                  ->nullable()
                  ->constrained('technicians')
                  ->onDelete('cascade')
                  ->after('handphone_id');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // 🔹 Hapus foreign key dan kolom kalau rollback
            $table->dropForeign(['technician_id']);
            $table->dropColumn('technician_id');
        });
    }
};
