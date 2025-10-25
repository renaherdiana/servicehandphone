<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi
     */
    public function up(): void
    {
        Schema::table('service_items', function (Blueprint $table) {
            // 🧩 Tambahkan kolom deleted_at untuk soft delete
            $table->softDeletes()->after('is_active');
        });
    }

    /**
     * Rollback migrasi
     */
    public function down(): void
    {
        Schema::table('service_items', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
