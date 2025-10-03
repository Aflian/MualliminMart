<?php

use App\Models\Transaction;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Kasir\TransactionPrintController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// routes/web.php
Route::get('/kasir/transactions/{id}/print', [TransactionPrintController::class, 'print'])
    ->name('transactions.print');


Route::get('/katalog',[ProductController::class,'index'])->name('katalog');
