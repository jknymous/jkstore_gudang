<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\StokKeluarController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserController;

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
        Route::resource('toko', TokoController::class);
        Route::resource('barang', BarangController::class);
        Route::resource('stok-keluar', StokKeluarController::class)->only(['index', 'create', 'store']);
        Route::resource('purchase', PurchaseController::class);
        Route::post('purchase/{purchase}/selesai', [PurchaseController::class, 'selesai'])->name('purchase.selesai');
        Route::post('purchase/{purchase}/retur', [PurchaseController::class, 'retur'])->name('purchase.retur');
        Route::resource('users', UserController::class);
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');
    });
    
    Route::middleware(['auth', 'isGudang'])->prefix('gudang')->group(function () {
        // Route untuk gudang
        Route::resource('barang', BarangController::class);
        Route::resource('stok-keluar', StokKeluarController::class)->only(['index', 'create', 'store']);
        Route::resource('purchase', PurchaseController::class);
        Route::post('purchase/{purchase}/selesai', [PurchaseController::class, 'selesai'])->name('purchase.selesai');
        Route::post('purchase/{purchase}/retur', [PurchaseController::class, 'retur'])->name('purchase.retur');
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');
    });
});

require __DIR__.'/auth.php';
