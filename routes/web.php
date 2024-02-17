<?php

use App\Http\Controllers\CompaignsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationsController;
use App\Http\Controllers\DonorsController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', '/login');

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('compaigns', CompaignsController::class)->name('compaigns.index');
    Route::get('donations', DonationsController::class)->name('donations.index');
    Route::get('plans', PlanController::class)->name('plans.index');
    Route::get('donors', DonorsController::class)->name('donors.index');
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::post('/update', [ProfileController::class, 'update'])->name('update');
        Route::post('/change-password', [ProfileController::class, 'updatePassword'])->name('change-password');
    });
});
