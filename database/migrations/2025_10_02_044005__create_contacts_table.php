<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // RELASI KE COMPANY: Wajib (NOT NULL). Restrict agar Company tidak bisa dihapus jika ada Kontak.
            $table->foreignId('company_id')->constrained()->onDelete('restrict'); 
            
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email', 150)->nullable();
            $table->string('phone_number', 50)->nullable();
            $table->string('job_title', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->boolean('is_customer')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
