<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AdminController;

// Public routes
Route::middleware('web')->group(function () {

    // Home page - accessible after login
    Route::get('/', [HomeController::class, 'index'])
        ->middleware('auth')
        ->name('home');

    // Optional: redirect /home to /
    Route::get('/home', function () {
        return redirect()->route('home');
    })->middleware('auth');

    // Authentication routes (guest only)
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login')
        ->middleware('guest');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest');

    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register')
        ->middleware('guest');
    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('guest');

    // Logout routes
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/logout', function () {
        auth()->logout();
        return redirect()->route('login');
    })->name('logout.get');
});

// Protected user routes
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [ItemController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/user/claim', [ItemController::class, 'userClaim'])->name('user.claim.get');
    Route::post('/user/claim', [ItemController::class, 'claimItem'])->name('user.claim');
});

// Admin routes
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [ItemController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/reported', [ItemController::class, 'reportedItems'])->name('admin.reported');
    Route::get('/admin/found', [AdminController::class, 'found'])->name('admin.found');
    Route::get('/admin/lost', [AdminController::class, 'lost'])->name('admin.lost');
    Route::get('/admin/claim', [AdminController::class, 'claim'])->name('admin.claim');

    // Fallback for missing item ID
    Route::get('/admin/items/edit', function () {
        return redirect()->route('admin.reported');
    })->name('admin.items.edit.missing');

    // Item CRUD
    Route::post('/admin/items', [ItemController::class, 'store'])->name('admin.items.store');
    Route::get('/admin/items/{id}/edit', [ItemController::class, 'edit'])->name('admin.items.edit');
    Route::put('/admin/items/{id}', [ItemController::class, 'update'])->name('admin.items.update');
    Route::delete('/admin/items/{id}', [ItemController::class, 'destroy'])->name('admin.items.destroy');
});