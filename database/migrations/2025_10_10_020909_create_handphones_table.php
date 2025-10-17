<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('handphones', function (Blueprint $table) {
            $table->id();
            $table->string('brand'); 
            $table->string('model');
            $table->integer('release_year')->nullable();
            $table->string('image')->nullable();
            $table->enum('is_active', ['active', 'nonactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('handphones');
    }
};
