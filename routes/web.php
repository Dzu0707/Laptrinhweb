<?php

use Illuminate\Support\Facades\Route;

// ===== Controllers =====
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ProfileController;
// ===== Admin Controllers =====
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\AdminPromotionController;


// =====================
// 🔹 TRANG NGƯỜI DÙNG
// =====================
Route::get('/', [ProductController::class, 'home'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// Tin tức
Route::get('/news', [PostController::class, 'index'])->name('posts.index');
Route::get('/news/{slug}', [PostController::class, 'show'])->name('posts.show');


// =====================
// 🔹 GIỎ HÀNG
// =====================
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Mã khuyến mãi
Route::post('/cart/apply-coupon', [PromotionController::class, 'apply'])->name('cart.applyCoupon');
Route::post('/cart/remove-coupon', [PromotionController::class, 'remove'])->name('cart.removeCoupon');


// =====================
// 🔹 THANH TOÁN (Chỉ user đăng nhập)
// =====================
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'place'])->name('checkout.place');

    Route::get('/orders', [CheckoutController::class, 'myOrders'])->name('orders.mine');
    Route::get('/orders/{order}', [CheckoutController::class, 'showOrder'])->name('orders.show');

    // Đánh giá sản phẩm
    Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('review.store');
});


// =====================
// 🔹 ĐĂNG NHẬP / ĐĂNG KÝ
// =====================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// =====================
// 🔹 KHU VỰC QUẢN TRỊ (ADMIN)
// =====================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {

    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Quản lý người dùng
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.updateRole');

    // Quản lý sản phẩm
    Route::resource('products', AdminProductController::class);
    Route::patch('/products/{product}/toggle', [AdminProductController::class, 'toggle'])
        ->name('products.toggle');

    // Quản lý danh mục
    Route::resource('categories', AdminCategoryController::class);
    Route::delete('/categories/{id}/with-products', [AdminCategoryController::class, 'destroyWithProducts'])
    ->name('categories.destroyWithProducts');

    // Quản lý đơn hàng
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show']);
    Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
        ->name('orders.status');

    // Báo cáo doanh thu
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');

    // Bài viết
    Route::resource('posts', AdminPostController::class);

    // Đánh giá sản phẩm
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::patch('/reviews/{review}/toggle', [AdminReviewController::class, 'toggle'])->name('reviews.toggle');
    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

    // Mã khuyến mãi
    Route::resource('promotions', AdminPromotionController::class)
        ->names('promotions')
        ->except(['show', 'edit', 'update']);
    // Quản lý người dùng
    Route::resource('users', AdminUserController::class)->except(['show', 'create', 'store']);

});
// =====================
// 🔹 HỒ SƠ NGƯỜI DÙNG
// =====================

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.delete');
});




