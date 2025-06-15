<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// RUTE PUBLIK
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/berita-publik', [BeritaController::class, 'indexPublik'])->name('berita.publik.index');
Route::get('/berita-publik/{berita}', [BeritaController::class, 'showPublik'])->name('berita.publik.show');


// RUTE YANG MEMERLUKAN AUTENTIKASI
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // =======================================================
    // BAGIAN INI DIRAPIKAN
    // --- MANAJEMEN BERITA (KHUSUS UNTUK USER LOGIN) ---
    Route::prefix('manajemen-berita')->name('berita.')->group(function () {
        Route::get('/', [BeritaController::class, 'index'])->name('index');
        Route::get('/create', [BeritaController::class, 'create'])->name('create');
        Route::post('/', [BeritaController::class, 'store'])->name('store');
        Route::get('/{post}/edit', [BeritaController::class, 'edit'])->name('edit');
        Route::put('/{post}', [BeritaController::class, 'update'])->name('update');
        Route::delete('/{post}', [BeritaController::class, 'destroy'])->name('destroy');

        // Rute Approval (KHUSUS EDITOR)
        Route::patch('/{berita}/approve', [BeritaController::class, 'approve'])->name('approve')->middleware('role:editor');
    });
    // =======================================================

    // --- MANAJEMEN KATEGORI (KHUSUS ADMIN) ---
    Route::middleware('role:admin')->group(function() {
        Route::resource('kategori', KategoriController::class);
    });

});

require __DIR__.'/auth.php';