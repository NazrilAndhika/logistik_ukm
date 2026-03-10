<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', [UserController::class, 'index'])
->middleware(['auth', 'verified'])
->name('dashboard');

// Tambahkan rute POST untuk memproses peminjaman
Route::post('/pinjam', [UserController::class,
 'storePinjam'])->middleware(['auth', 'verified'])->name('pinjam.store');

// Tambahkan di dalam routes/web.php
Route::get('/status-peminjaman', [UserController::class, 'statusPeminjaman'])->middleware(['auth', 'verified'])->name('status.peminjaman');

// Route Riwayat Peminjaman
Route::get('/riwayat-peminjaman', [UserController::class, 'riwayatPeminjaman'])->middleware(['auth', 'verified'])->name('riwayat.peminjaman');

// RUTE KHUSUS ADMIN (Dipasang pengaman 'role:admin')
// RUTE KHUSUS ADMIN
    Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Rute Halaman Validasi Pinjam (Semua Data)
    Route::get('/validasi', [AdminController::class, 'validasi'])->name('admin.validasi');
    
    // Rute aksi validasi (yang sebelumnya)
    Route::put('/transaksi/{id}/setujui', [AdminController::class, 'setujui'])->name('admin.setujui');
    Route::put('/transaksi/{id}/tolak', [AdminController::class, 'tolak'])->name('admin.tolak');

    // Rute Halaman Pengembalian & Aksi Kembalikan
    Route::get('/pengembalian', [AdminController::class, 'pengembalian'])->name('admin.pengembalian');
    Route::put('/transaksi/{id}/kembali', [AdminController::class, 'kembalikan'])->name('admin.kembalikan');

    // Rute Halaman Riwayat & Laporan
    Route::get('/riwayat', [AdminController::class, 'riwayat'])->name('admin.riwayat');

    // Rute Manajemen Data Alat (BARU)
    Route::get('/items', [ItemController::class, 'index'])->name('admin.items');
    Route::post('/items', [ItemController::class, 'store'])->name('admin.items.store');
    Route::put('/items/{id}', [ItemController::class, 'update'])->name('admin.items.update');
    Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('admin.items.destroy');
    
});

    Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route Profil User
    Route::get('/profil', [UserController::class, 'editProfile'])->middleware(['auth', 'verified'])->name('profil.edit');
    Route::put('/profil', [UserController::class, 'updateProfile'])->middleware(['auth', 'verified'])->name('profil.update');
    });

    // Rute Manajemen Data Anggota
    Route::get('/anggota', [AnggotaController::class, 'index'])->name('admin.anggota');
    Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy'])->name('admin.anggota.destroy');

require __DIR__.'/auth.php';
