<?php

use App\Http\Controllers\CompaignsExportController;
use App\Http\Controllers\CompaignsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationsController;
use App\Http\Controllers\DonationsExportController;
use App\Http\Controllers\DonorsController;
use App\Http\Controllers\PayoutController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WithdrawController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Stripe\Payout;

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
Route::stripeWebhooks('stripe/webhooks');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::post('/withdraw', WithdrawController::class)->name('withdraw');
    Route::get('campaigns/export', CompaignsExportController::class)->name('compaigns.export');
    Route::get('campaigns', CompaignsController::class)->name('compaigns.index');
    Route::get('donations/export', DonationsExportController::class)->name('donations.export');
    Route::get('donations', DonationsController::class)->name('donations.index');
    Route::get('plans', PlanController::class)->name('plans.index');
    Route::get('donors', DonorsController::class)->name('donors.index');
    Route::get('payouts', PayoutController::class)->name('payouts.index');
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::post('/update', [ProfileController::class, 'update'])->name('update');
        Route::post('/change-password', [ProfileController::class, 'updatePassword'])->name('change-password');
    });
});
