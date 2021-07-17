<?php

use App\Http\Livewire\Customer\CustomerList;
use App\Http\Livewire\Product\ProductList;
use App\Http\Livewire\Staff\StaffList;
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
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->prefix('product')->name('product.')->group(function () {
    Route::get('/list', ProductList::class)->name('list');
});

Route::middleware(['auth:sanctum', 'verified'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/list', StaffList::class)->name('list');
});

Route::middleware(['auth:sanctum', 'verified'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/list', CustomerList::class)->name('list');
});
