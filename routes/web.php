<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminScanController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — POCYCLE
|--------------------------------------------------------------------------
*/

// === Public Routes ===
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/tutorial', [TutorialController::class, 'index'])->name('tutorial.index');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

// === Authenticated Routes ===
Route::middleware(['auth'])->group(function () {

    // Scan Pupuk
    Route::get('/scan', function () {
        return redirect()->route('scan.create');
    });
    Route::get('/scan/create', [ScanController::class, 'create'])->name('scan.create');
    Route::post('/scan', [ScanController::class, 'store'])->name('scan.store');
    Route::post('/scan/restart', [ScanController::class, 'restart'])->name('scan.restart');
    Route::get('/scan/{scanHistory}', [ScanController::class, 'show'])->name('scan.show');

    // Panen POC
    Route::get('/harvest/verify', [App\Http\Controllers\HarvestController::class, 'create'])->name('harvest.verify');
    Route::post('/harvest/verify', [App\Http\Controllers\HarvestController::class, 'store'])->name('harvest.store');
    
    // Tutorial (Start Batch)
    Route::post('/tutorial/start-batch', [TutorialController::class, 'startBatch'])->name('tutorial.startBatch');

    // Riwayat POC
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');

    // Notifikasi
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

    // Push Subscriptions
    Route::post('/push-subscriptions', [App\Http\Controllers\PushSubscriptionController::class, 'update'])->name('push-subscriptions.update');
    Route::delete('/push-subscriptions', [App\Http\Controllers\PushSubscriptionController::class, 'destroy'])->name('push-subscriptions.destroy');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// === Admin Routes ===
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Artikel CRUD
    Route::get('/articles', [AdminArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [AdminArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [AdminArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [AdminArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [AdminArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [AdminArticleController::class, 'destroy'])->name('articles.destroy');

    // Data Pupuk (Scan Monitoring)
    Route::get('/scans', [AdminScanController::class, 'index'])->name('scans.index');
    Route::get('/scans/{scanHistory}', [AdminScanController::class, 'show'])->name('scans.show');

    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/toggle-admin', [UserController::class, 'toggleAdmin'])->name('users.toggleAdmin');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';
