<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('services', function (Blueprint $table) {
            // 🔹 Hapus kolom lama 'handphone' jika masih ada (biar tidak bentrok)
            if (Schema::hasColumn('services', 'handphone')) {
                $table->dropColumn('handphone');
            }

            // 🔹 Tambahkan kolom 'handphone_id' hanya jika belum ada
            if (!Schema::hasColumn('services', 'handphone_id')) {
                $table->foreignId('handphone_id')
                    ->nullable()
                    ->constrained('handphones')
                    ->onDelete('set null')
                    ->after('customer');
            }
        });
    }

    public function down(): void {
        Schema::table('services', function (Blueprint $table) {
            // 🔹 Drop relasi & kolom dengan aman
            if (Schema::hasColumn('services', 'handphone_id')) {
                $table->dropForeign(['handphone_id']);
                $table->dropColumn('handphone_id');
            }

            // 🔹 Tambahkan kembali kolom lama (opsional)
            if (!Schema::hasColumn('services', 'handphone')) {
                $table->string('handphone')->nullable();
            }
        });
    }
};
