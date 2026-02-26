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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users (siapa yang pinjam)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Relasi ke tabel items (barang apa yang dipinjam)
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            
            $table->date('tgl_pinjam');
            $table->date('tgl_kembali')->nullable(); // Boleh kosong kalau belum dikembalikan
            $table->enum('status', ['pending', 'dipinjam', 'dikembalikan'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
