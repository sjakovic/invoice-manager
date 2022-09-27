<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CompanyController;

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
    return view('welcome');
});

Route::controller(InvoiceController::class)->group(function () {
    Route::get('/invoices', 'index')->name('invoices');
    Route::get('/invoices/create', 'create')->name('invoice-create');
    Route::get('/invoices/{id}', 'edit')->name('invoice-edit');
    Route::put('/invoices', 'store')->name('invoice-store');
    Route::post('/invoices/{id}', 'update')->name('invoice-update');
    Route::get('/invoices/{id}/pdf', 'pdf')->name('invoice-pdf');
});

Route::controller(CustomerController::class)->group(function () {
    Route::get('/customers', 'index')->name('customers');
    Route::get('/customers/create', 'create')->name('customer-create');
    Route::put('/customers', 'store')->name('customer-store');
    Route::post('/customers', 'update')->name('customer-update');
});

Route::controller(CompanyController::class)->group(function() {
    Route::get('/company', 'edit')->name('company-edit');
    Route::post('/company/{id}', 'update')->name('company-update');
});


