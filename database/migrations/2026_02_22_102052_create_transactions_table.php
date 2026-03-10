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
            // Relasi ke users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Relasi ke items
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            
            $table->integer('jumlah'); // <-- Ini kolom jumlahnya
            $table->date('tgl_pinjam');
            $table->date('tgl_kembali');
            $table->string('status')->default('Pending');
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
