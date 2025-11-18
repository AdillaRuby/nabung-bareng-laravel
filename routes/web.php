   <?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SavedPaymentController;
use App\Http\Controllers\PendingPaymentController;
use App\Http\Controllers\WithdrawController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['check.login'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Saved Payments
    Route::resource('saved-payments', SavedPaymentController::class);

    // Pending Payments
    Route::resource('pending-payments', PendingPaymentController::class);

    // Withdraws
    Route::resource('withdraws', WithdrawController::class);
});
