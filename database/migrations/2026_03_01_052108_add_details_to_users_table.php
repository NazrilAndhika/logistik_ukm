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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom baru ke tabel users
            $table->string('nim')->unique()->nullable()->after('id');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('name');
            $table->string('no_hp')->nullable()->after('email');
            
            // Kolom role ini penting banget buat bedain mana Admin, mana User (Mahasiswa)
            $table->string('role')->default('user')->after('password'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom jika suatu saat migration di-rollback
            $table->dropColumn(['nim', 'jenis_kelamin', 'no_hp', 'role']);
        });
    }
};