<?php

use App\Http\Controllers\ProfileController;
use App\Services\Print\PrintService;
use Illuminate\Http\Request;
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

Route::redirect('/', '/login');


Route::get('/dashboards', function () {
    $results = session()->get('results');

    return PrintService::createPdfFromView('result.pdf', 'livewire.reports.sales-pdf', ['results' => $results]);
})->middleware(['auth'])->name('sale-reports');

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

        //Sales
        Route::namespace('Sales')->group(function () {

            Route::get('/sales', Table::class)->name('sales');
        });

        //Sales
        Route::namespace('Purchase')->group(function () {

            Route::get('/purchases', Table::class)->name('purchases');
        });

        //Vendor
        Route::namespace('Vendor')->group(function () {

            Route::get('/vendor', Table::class)->name('vendor');
        });

        //Employee
        Route::namespace('Employee')->group(function () {

            Route::get('/employee', Table::class)->name('employee');
        });


        //Product
        Route::namespace('Product')->group(function () {

            Route::get('/product', Table::class)->name('product');
        });

        //Product
        Route::namespace('Reports')->prefix('report')->group(function () {

            Route::get('/sale-report', SaleReport::class)->name('sale-report');
        });
    });
});

require __DIR__ . '/auth.php';
