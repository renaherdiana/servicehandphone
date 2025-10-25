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
        Schema::table('handphones', function (Blueprint $table) {
            
            $table->softDeletes()->after('is_active');
        });
    }

    /**
     * Kembalikan migrasi (rollback)
     */
    public function down(): void
    {
        Schema::table('handphones', function (Blueprint $table) {
        
            $table->dropSoftDeletes();
        });
    }
};
