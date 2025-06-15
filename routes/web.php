<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController; // <-- Jangan lupa import

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Rute yang memerlukan Autentikasi
Route::middleware('auth')->group(function () {

    // =======================================================
    // INI BAGIAN YANG DIPERBAIKI
    // Menggunakan DashboardController untuk halaman dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // =======================================================

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- FITUR BERITA ---
    Route::resource('berita', BeritaController::class);
    Route::patch('/berita/{berita}/approve', [BeritaController::class, 'approve'])->name('berita.approve')->middleware('role:editor');

    // --- FITUR KHUSUS ADMIN ---
    Route::middleware('role:admin')->group(function() {
        Route::resource('kategori', KategoriController::class);
    });

});

require __DIR__.'/auth.php';