<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::namespace('App\Http\Livewire')->group(function () {

    //? Routes that can be accessed only when logging in
    Route::middleware(['auth', 'verified'])->group(function () {

        //? Route for dashboard page
        Route::prefix('/dashboard')->name('dashboard.')->group(function () {

            Route::get('/', Index::class)->name('index');

            // livewire crud-generator Tall
            Route::get('/tall-crud-generator', TallCrud::class)->name('tall-crud-generator');
        });

        //? Financial
        Route::namespace('Financial')->group(function () {

            Route::get('/financial', Table::class)->name('financial');
        });

        //? Inventory
        Route::namespace('Inventory')->group(function () {

            Route::get('/inventory', Table::class)->name('inventory');
        });

        //PurchaseOrder
        Route::namespace('PurchaseOrder')->group(function () {

            Route::get('/purchase-order', Table::class)->name('purchase-order');
        });

        //SalesOrder
        Route::namespace('SalesOrder')->group(function () {

            Route::get('/sales-order', Table::class)->name('sales-order');
        });

        //Vendor
        Route::namespace('Vendor')->group(function () {

            Route::get('/vendor', Table::class)->name('vendor');
        });

        //Employee
        Route::namespace('Employee')->group(function () {

            Route::get('/employee', Table::class)->name('employee');
        });
    });
});

require __DIR__ . '/auth.php';
