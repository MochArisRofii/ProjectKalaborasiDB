<?php

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
    Route::get('/admin', [ProdukController::class, 'index'])->name('admin.produk.index');
    Route::resource('produk', ProdukController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('transaction-details', TransactionDetailController::class);
    Route::delete('transaction-details/{id}', [TransactionDetailController::class, 'destroy'])->name('admin.transaction-details.destroy');
});

Route::middleware(['auth', 'CheckLevel:kasir'])->group(function () {
    Route::get('/kasir', [ProdukController::class, 'index'])->name('kasir.produk.index');
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('transaction-details', TransactionDetailController::class);
    Route::delete('transaction-details/{id}', [TransactionDetailController::class, 'destroy'])->name('kasir.transaction-details.destroy');
});
