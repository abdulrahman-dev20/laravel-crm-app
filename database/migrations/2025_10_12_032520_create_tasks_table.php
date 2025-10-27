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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // Relasi ke User (Siapa pemilik/penanggung jawab Task)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Relasi ke Contact (Task ini ditujukan untuk Kontak mana)
            $table->foreignId('contact_id')->nullable()->constrained()->onDelete('set null'); // nullable jika ada Task umum
            
            // Kolom Data Task
            $table->string('title'); // Judul tugas (misalnya: Follow-up Call)
            $table->text('description')->nullable();
            $table->date('due_date'); // Tanggal jatuh tempo
            $table->boolean('is_completed')->default(false); // Status Task
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
