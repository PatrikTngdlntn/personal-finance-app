<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;


// USER
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\WalletController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\BudgetController;
use App\Http\Controllers\User\SavingTransactionController;
use App\Http\Controllers\User\SavingController;
use App\Http\Controllers\User\SubscriptionController;
use App\Http\Controllers\User\ReceiptController;

// ADMIN
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Redirect Root
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }

    return redirect()->route('login');
});


// route user
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Wallet
    Route::resource('wallet', WalletController::class);
    // Transaction
    Route::resource('transaction', TransactionController::class);
    // Category
    Route::resource('category', CategoryController::class);
    // Budget
    Route::resource('budget', BudgetController::class);
    // Saving Transaction
    Route::resource('saving-transaction', SavingTransactionController::class);
    // saving
    Route::resource('saving', SavingController::class);
    // subscription
    Route::resource('subscription', SubscriptionController::class);

    Route::post('/subscription/{subscription}/pay', [SubscriptionController::class, 'pay'])->name('subscription.pay');

    Route::get('/receipt/create', [ReceiptController::class, 'create'])->name('receipt.create');

    Route::post('/receipt/scan', [ReceiptController::class, 'scan'])->name('receipt.scan');
});
/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');
});


/*
|--------------------------------------------------------------------------
| PROFILE (GLOBAL LOGIN USER)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
