<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — POCYCLE
|--------------------------------------------------------------------------
*/

// === Public Routes ===
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

// === Authenticated Routes ===
Route::middleware(['auth'])->group(function () {

    // Scan Pupuk
    Route::get('/scan', [ScanController::class, 'create'])->name('scan.create');
    Route::post('/scan', [ScanController::class, 'store'])->name('scan.store');
    Route::get('/scan/{scanHistory}', [ScanController::class, 'show'])->name('scan.show');

    // Riwayat POC
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');

    // Notifikasi
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
