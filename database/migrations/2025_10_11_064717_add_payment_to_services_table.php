<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Tambahkan kolom baru hanya jika belum ada
            if (!Schema::hasColumn('services', 'payment_amount')) {
                $table->decimal('payment_amount', 10, 2)->nullable()->after('cost');
            }

            if (!Schema::hasColumn('services', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('payment_amount');
            }
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'payment_amount')) {
                $table->dropColumn('payment_amount');
            }
            if (Schema::hasColumn('services', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
        });
    }
};
