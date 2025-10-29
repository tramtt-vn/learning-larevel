<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Middleware\CheckLogin;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\VerificationController;
// use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

// Authenticated routes
Route::middleware(CheckLogin::class)->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    // Email verification routes
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
});
Route::middleware('guest')->group(function () {
    Route::get('/auth/verify-email', [VerificationController::class, 'show'])->name('auth.verify-email');
    Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});


Route::resource('posts', PostController::class);
Route::controller(ProductController::class)->group(function () {
    Route::get('/products/{id}', 'show')->name('products.detail');
    Route::get('/products','index')->name('products.index');
});
Route::middleware('guest:customer')->group(function () {
    Route::get('/customer/register', [CustomerController::class, 'showRegisterForm'])->name('customer.register');
    Route::post('/customer/register', [CustomerController::class, 'register'])->name('customer.register.submit');
    Route::get('/customer/login', [CustomerController::class, 'showLoginForm'])->name('customer.login');
    Route::post('/customer/login', [CustomerController::class, 'login'])->name('customer.login.submit');
});
Route::middleware('auth:customer')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // Email verification
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
        ->name('verification.verify');

    // Cart routes
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::put('/update/{item}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{item}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    });
});

?>
