<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsumerController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\BillingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/render', [App\Http\Controllers\RenderController::class, 'index'])->name('render');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {

    // consumers table routes
    Route::prefix('consumers')->group(function () {
        Route::get('/', [ConsumerController::class, 'index'])->name('consumers.index'); // Show list of consumers
        Route::get('/create', [ConsumerController::class, 'create'])->name('consumers.create'); // Show create form
        Route::post('/', [ConsumerController::class, 'store'])->name('consumers.store'); // Store a new consumer
        Route::get('/edit/{id}', [ConsumerController::class, 'edit'])->name('consumers.edit'); // Edit a consumer
        Route::post('/{id}', [ConsumerController::class, 'update'])->name('consumers.update'); // Update a consumer
        Route::delete('/{id}', [ConsumerController::class, 'destroy'])->name('consumers.destroy'); // destroy a consumer
    });

    // settings table routes
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('settings.index'); 
        Route::put('/{id}', [SettingController::class, 'update'])->name('settings.update'); // Update a user
        Route::get('/general', [SettingController::class, 'general_setting'])->name('settings.general'); // Update a general settings
        Route::put('/', [SettingController::class, 'general_update'])->name('settings.store'); // Store a new consumer
    });


    // readings table routes
    Route::prefix('billings')->group(function () {
        Route::get('/', [BillingController::class, 'index'])->name('billings.index'); 
        Route::get('/create', [BillingController::class, 'create'])->name('billings.create'); // Show create form
        Route::post('/store', [BillingController::class, 'store'])->name('billings.store'); // Show create form
        Route::post('/pay', [BillingController::class, 'pay'])->name('billings.pay'); // Show create form
        Route::get('/view/{id}/{consumer_id}', [BillingController::class, 'view'])->name('billings.view'); // Show create form
        Route::delete('/{id}', [BillingController::class, 'destroy'])->name('billings.destroy'); // destroy a consumer
        
    });
});




