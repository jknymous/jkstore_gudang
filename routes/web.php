<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return view('dashboard.admin');
    } elseif (auth()->user()->role === 'gudang') {
        return view('dashboard.gudang');
    } else {
        abort(403); // role tidak dikenali
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(function () {
        // Route untuk admin
        Route::resource('toko', \App\Http\Controllers\TokoController::class);
    });
    
    Route::middleware(['auth', 'isGudang'])->prefix('gudang')->group(function () {
        // Route untuk gudang
    });
});

require __DIR__.'/auth.php';
