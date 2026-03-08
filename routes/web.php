<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes (custom - using our AuthController)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes - requires authentication
Route::middleware(['auth'])->group(function () {
    // Home page
    Route::get('/home', function () {
        return view('home');
    })->name('home');
    
    // Items - User Dashboard (view lost, found, claimed items)
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/lost', [ItemController::class, 'index'])->name('items.lost');
    Route::get('/items/found', [ItemController::class, 'index'])->name('items.found');
    Route::get('/items/claimed', [ItemController::class, 'index'])->name('items.claimed');
    
    // Claim item
    Route::post('/items/{item}/claim', [ItemController::class, 'claim'])->name('items.claim');
});

// Protected routes - Admin only
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin dashboard
    Route::get('/admin/items', [ItemController::class, 'adminIndex'])->name('admin.items');
    Route::get('/admin/found-items', [ItemController::class, 'foundItems'])->name('admin.found-items');
    
    // Item CRUD
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
});

// Note: Don't use require __DIR__.'/auth.php' as we have custom auth routes

