<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Add version number before
// User
Route::prefix('invoices')->name('invoice.')->group(function() {
    Route::post('/', 'InvoiceController@create')->name('create');
    Route::get('/{id}', 'InvoiceController@detail')->name('detail');
});
