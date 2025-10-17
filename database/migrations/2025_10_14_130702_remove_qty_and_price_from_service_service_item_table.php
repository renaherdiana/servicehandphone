<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_service_item', function (Blueprint $table) {
            // 🧹 Hapus kolom qty dan price
            if (Schema::hasColumn('service_service_item', 'qty')) {
                $table->dropColumn('qty');
            }
            if (Schema::hasColumn('service_service_item', 'price')) {
                $table->dropColumn('price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('service_service_item', function (Blueprint $table) {
            // 🔙 Balikin kalau di-rollback
            $table->integer('qty')->default(0);
            $table->decimal('price', 10, 2)->default(0);
        });
    }
};
