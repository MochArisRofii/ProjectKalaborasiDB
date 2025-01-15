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

// Rute untuk autentikasi (login & logout)
// Route::get('/', function () {
    //     return view('produk');
    // });
Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/', [ProdukController::class, 'index'])->name('produk.index');
    Route::resource('produk', ProdukController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('transaction-details', TransactionDetailController::class);
    Route::delete('transaction-details/{id}', [TransactionDetailController::class, 'destroy'])->name('transaction-details.destroy');
});
