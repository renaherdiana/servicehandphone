<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('technicians', function (Blueprint $table) {
            $table->id(); // Kolom ID (otomatis jadi nomor urut / primary key)
            $table->string('name'); // Nama Teknisi
            $table->boolean('is_active')->default(true); // Status aktif / nonaktif
            $table->timestamps(); // created_at & updated_at
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('technicians');
    }
};
