<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('interactions', function (Blueprint $table) {
            $table->id();

            // Relasi ke User (Siapa yang mencatat interaksi)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Relasi ke Contact (Interaksi ini terkait dengan Kontak mana)
            // Kritis: Pastikan Contact Model/Migration sudah benar.
            $table->foreignId('contact_id')->constrained()->onDelete('cascade');

            // Kolom Data Interaksi
            $table->enum('type', ['Call', 'Email', 'Meeting', 'Note']); // Jenis interaksi
            $table->text('summary'); // Ringkasan interaksi/catatan
            $table->timestamp('scheduled_at')->nullable(); // Kapan interaksi terjadi/dijadwalkan

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interactions');
    }
};