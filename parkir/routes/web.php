<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VehicleTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', fn() => redirect()->route('transactions.index'));

Route::resource('locations', LocationController::class);

Route::resource('vehicle-types', VehicleTypeController::class);

Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('/transactions/enter', [TransactionController::class, 'enter'])->name('transactions.enter');
Route::post('/transactions/exit', [TransactionController::class, 'exit'])->name('transactions.exit');
Route::get('/transactions/all', [TransactionController::class, 'viewAll'])->name('transactions.all');
Route::get('/transactions/ticket/{noTiket}', [TransactionController::class, 'getTicket'])->name('transactions.get-ticket');
Route::get('/transactions/show-ticket/{noTiket}', [TransactionController::class, 'showTicket'])->name('transactions.show-ticket');

Route::get('/reports/location', function () {
    $locations = collect(); // fungsi report dinonaktifkan
    return view('reports.location', compact('locations'));
})->name('reports.location');

Route::get('/reports/transaction', function () {
    $transactions = collect(); // fungsi report dinonaktifkan
    return view('reports.transaction', compact('transactions'));
})->name('reports.transaction');
