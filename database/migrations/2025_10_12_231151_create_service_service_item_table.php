<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_service_item', function (Blueprint $table) {
            $table->id();

            // Tulis nama tabel secara eksplisit biar aman
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('service_item_id')->constrained('service_items')->onDelete('cascade');

            $table->integer('qty')->default(1);
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('subtotal', 12, 2)->default(0);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_service_item');
    }
};
