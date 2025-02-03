<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransactionDetailController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Auth::routes();
Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth', 'CheckLevel:admin'])->group(function () {
    Route::get('/admin', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::resource('admin/produk', ProdukController::class);
    Route::resource('admin/transaksi', TransaksiController::class);
    Route::resource('admin/transaction-details', TransactionDetailController::class);
    Route::delete('admin/transaction-details/{id}', [TransactionDetailController::class, 'destroy'])->name('transaction-details.destroy');
});

// Route untuk kasir
Route::middleware(['auth', 'CheckLevel:kasir'])->group(function () {
    Route::get('/kasir', [ProdukController::class, 'index'])->name('kasir.dashboard');
    Route::get('kasir/produk', [ProdukController::class, 'index'])->name('kasir.produk.index');
    Route::resource('kasir/transaksi', TransaksiController::class)->names([
        'index' => 'kasir.transaksi.index',
        'create' => 'kasir.transaksi.create',
        'store' => 'kasir.transaksi.store',
        'show' => 'kasir.transaksi.show',
    ]);
    Route::resource('transaction-details', TransactionDetailController::class)->only(['index', 'create', 'store']); // Membatasi akses

});

