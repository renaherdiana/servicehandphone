<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'total_cost')) {
                $table->decimal('total_cost', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('services', 'other_cost')) {
                $table->decimal('other_cost', 12, 2)->nullable();
            }
            if (!Schema::hasColumn('services', 'paid')) {
                $table->decimal('paid', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('services', 'change')) {
                $table->decimal('change', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('services', 'paymentmethod')) {
                $table->enum('paymentmethod', ['cash', 'transfer'])->nullable();
            }
            if (!Schema::hasColumn('services', 'status_paid')) {
                $table->enum('status_paid', ['paid', 'debt', 'unpaid'])->default('unpaid');
            }
            if (!Schema::hasColumn('services', 'received_date')) {
                $table->date('received_date')->nullable();
            }
            if (!Schema::hasColumn('services', 'completed_date')) {
                $table->date('completed_date')->nullable();
            }
        });
    }


    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'total_cost',
                'other_cost',
                'paid',
                'change',
                'paymentmethod',
                'status_paid',
                'received_date',
                'completed_date',
            ]);
        });
    }
};
