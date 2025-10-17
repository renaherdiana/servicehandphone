<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('invoice')->unique();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('handphone_id')->nullable()->constrained('handphones')->onDelete('set null'); // relasi ke tabel handphones
            $table->string('technician');
            $table->decimal('cost', 15, 2)->nullable();
            $table->enum('status', ['accepted', 'process', 'finished', 'taken', 'cancelled'])->default('accepted');

            // Tambahan kolom pembayaran
            $table->decimal('total_cost', 12, 2)->default(0);
            $table->decimal('other_cost', 12, 2)->nullable();
            $table->decimal('paid', 12, 2)->default(0);
            $table->decimal('change', 12, 2)->default(0);
            $table->enum('paymentmethod', ['cash', 'transfer'])->nullable();
            $table->enum('status_paid', ['paid', 'debt', 'unpaid'])->default('unpaid');
            $table->date('received_date')->nullable();
            $table->date('completed_date')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('services');
    }
};
