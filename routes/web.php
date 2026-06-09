<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TransactionController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/transaction/{id}', [DashboardController::class, 'showDetail'])->name('transaction.detail');
    
    Route::resource('categories', CategoryController::class);
    Route::resource('menu', MenuController::class);
    
    Route::get('/pos', [TransactionController::class, 'pos'])->name('pos.index');
    Route::post('/pos/store', [TransactionController::class, 'store'])->name('pos.store');
    Route::get('/pos/print/{id}', [TransactionController::class, 'print'])->name('pos.print');
});