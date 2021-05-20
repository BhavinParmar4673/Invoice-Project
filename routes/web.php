<?php

use App\Http\Controllers\invoicecontroller;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
Route::get('/validation', function () {
    return view('invoice.validation');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




Route::middleware(['auth'])->group(function () {
    //category module
    Route::get('pdf/{id}','OrderController@pdfinvoice')->name('pdfinvoice');
    Route::get('orders/allinvoice', 'OrderController@allinvoice')->name('allinvoice');
    Route::resource('orders', 'OrderController');
});