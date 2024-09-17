<?php

use App\Http\Controllers\InvoiceController;
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
    return view('createInvoice');
});

Route::get('/index-invoice', [InvoiceController::class, 'indexInvoice'])->name('invoice.index');
Route::get('/total-amount', [InvoiceController::class, 'totalAmount'])->name('invoice.totalAmount');
Route::get('/total-Discount', [InvoiceController::class, 'totalDiscount'])->name('invoice.totalDiscount');
Route::get('/total-Bill', [InvoiceController::class, 'totalBill'])->name('invoice.totalBill');
Route::post('/store-invoice', [InvoiceController::class, 'storeInvoice'])->name('invoice.store');
Route::post('/edit-invoice', [InvoiceController::class, 'editInvoice'])->name('invoice.edit');


