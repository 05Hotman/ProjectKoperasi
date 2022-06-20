<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::middleware('auth')->group(function() {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('/karyawan', UserController::class, ['names' => 'user']);
    Route::resource('/nasabah', CustomerController::class, ['names' => 'customer']);

    Route::post('/karyawan/cetak', [UserController::class, 'print'])->name('user.print');
    Route::post('/nasabah/cetak', [CustomerController::class, 'print'])->name('customer.print');

    Route::as('transaction.')->prefix('transaksi')->group(function() {
        Route::resource('/pinjaman', LoanController::class, ['names' => 'loan']);
        Route::resource('/pembayaran', InstallmentController::class, ['names' => 'installment']);
        Route::resource('/simpanan', DepositController::class, ['names' => 'deposit']);

        Route::post('/pinjaman/cetak', [LoanController::class, 'print'])->name('loan.print');
        Route::post('/pembayaran/cetak', [InstallmentController::class, 'print'])->name('installment.print');
        Route::post('/simpanan/cetak', [DepositController::class, 'print'])->name('deposit.print');
    });

    Route::get('/pengaturan', [HomeController::class, 'profile'])->name('profile.show');
    Route::post('/pengaturan', [HomeController::class, 'update'])->name('profile.update');
});

