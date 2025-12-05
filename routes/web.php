<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Products
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/new', [ProductController::class, 'newArrivals'])->name('new');
    Route::get('/sale', [ProductController::class, 'sale'])->name('sale');
    Route::get('/bestsellers', [ProductController::class, 'bestsellers'])->name('bestsellers');
    Route::get('/category/{category}', [ProductController::class, 'category'])->name('category');
    Route::get('/{id}', [ProductController::class, 'show'])->name('show');
});

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('apply-coupon');
    Route::delete('/remove-coupon', [CartController::class, 'removeCoupon'])->name('remove-coupon');
    Route::get('/count', [CartController::class, 'count'])->name('count');
});

// Checkout Routes
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/', [CheckoutController::class, 'store'])->name('store');
});

// Order confirmation route
Route::get('/order/confirmation/{order}', [CheckoutController::class, 'confirmation'])->name('order.confirmation');

// Admin Routes (No Authentication for Now)
Route::prefix('admin-panel')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Products Management
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [AdminController::class, 'products'])->name('index');
        Route::get('/create', [AdminController::class, 'createProduct'])->name('create');
        Route::post('/', [AdminController::class, 'storeProduct'])->name('store');
        Route::get('/{product}/edit', [AdminController::class, 'editProduct'])->name('edit');
        Route::patch('/{product}', [AdminController::class, 'updateProduct'])->name('update');
        Route::delete('/{product}', [AdminController::class, 'destroyProduct'])->name('destroy');
    });
    
    // Orders Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminController::class, 'orders'])->name('index');
        Route::get('/{order}', [AdminController::class, 'showOrder'])->name('show');
        Route::put('/{order}', [AdminController::class, 'updateOrderStatus'])->name('update');
        Route::delete('/{order}', [AdminController::class, 'destroyOrder'])->name('destroy');
    });
});

// Wishlist
Route::prefix('wishlist')->name('wishlist.')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('index');
    Route::post('/toggle/{product}', [WishlistController::class, 'toggle'])->name('toggle');
    Route::post('/add/{product}', [WishlistController::class, 'add'])->name('add');
    Route::post('/remove/{product}', [WishlistController::class, 'remove'])->name('remove');
    Route::get('/check/{product}', [WishlistController::class, 'isInWishlist'])->name('check');
});

// Reviews (public index, authenticated create/update/delete)
Route::prefix('reviews')->name('reviews.')->group(function () {
    Route::get('/product/{product}', [ReviewController::class, 'index'])->name('index');
    
    Route::middleware('auth')->group(function () {
        Route::post('/product/{product}', [ReviewController::class, 'store'])->name('store');
        Route::put('/{review}', [ReviewController::class, 'update'])->name('update');
        Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('destroy');
        Route::post('/{review}/helpful', [ReviewController::class, 'markHelpful'])->name('helpful');
    });
});

// Newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Static Pages
Route::view('/collections', 'pages.collections')->name('collections');
Route::view('/gift-cards', 'pages.gift-cards')->name('gift-cards');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/shipping', 'pages.shipping')->name('shipping');
Route::view('/returns', 'pages.returns')->name('returns');
Route::view('/size-guide', 'pages.size-guide')->name('size-guide');
Route::view('/about', 'pages.about')->name('about');
Route::view('/careers', 'pages.careers')->name('careers');
Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/terms', 'pages.terms')->name('terms');

// Authentication Routes (uncomment if using Laravel Breeze/Jetstream/Fortify)
// require __DIR__.'/auth.php';
