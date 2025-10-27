<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            // RELASI KE USER: Wajib. Jika User dihapus, Company ini juga dihapus (cascade)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            $table->string('name')->unique();
            $table->string('website')->nullable();
            $table->string('phone_number', 50)->nullable();
            $table->string('address')->nullable();
            $table->string('industry', 100)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};