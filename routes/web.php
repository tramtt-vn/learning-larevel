<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Middleware\CheckLogin;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController;
// use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\CheckAdmin;

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['signed','throttle:6,1'])->name('verification.verify');

Route::middleware('guest')->group(function () {
    Route::get('/admin', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/admin', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/admin/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/admin/register', [AuthController::class, 'register'])->name('register.submit');
});

// Authenticated routes
Route::middleware(CheckLogin::class)->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');
     Route::get('/edit', [UserController::class, 'edit'])->name('users.edit');
     Route::put('/update', [UserController::class, 'update'])->name('users.update');
    // Email verification routes

});
Route::middleware(CheckAdmin::class)->group(function () {
    //Route::get('/admin/list', [UserController::class, 'index'])->name('admin.list');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.delete');
    Route::prefix('admin')->name('admin.')->group(function () {
    // Product Management
        Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}', [AdminProductController::class, 'show'])->name('products.show');
        Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    });

});
Route::middleware('guest')->group(function () {
    Route::get('/auth/verify-email', [VerificationController::class, 'show'])->name('auth.verify-email');
    Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});

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
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');
        // User management
        Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');

        Route::get('/edit', [CustomerController::class, 'edit'])->name('edit');
        Route::put('/update', [CustomerController::class, 'update'])->name('update');
    });
    // Email verification


    // Cart routes
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::put('/update/{item}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{item}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    });

    Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{id}/success', [OrderController::class, 'success'])->name('orders.success');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

?>
